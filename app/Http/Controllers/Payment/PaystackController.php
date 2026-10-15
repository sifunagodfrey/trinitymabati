<?php

/* -------------------
   Paystack payment controller. Handles the customer return callback and
   the server webhook: verifies the transaction with Paystack, marks the
   order paid, deducts stock, records the timeline and awards loyalty.
------------------- */

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Order;
use App\Models\Manage\Ecommerce\OrderStatusHistory;
use App\Models\Payment\PaymentTransaction;
use App\Services\LoyaltyService;
use App\Services\OrderEmailService;
use App\Services\Payment\PaystackService;
use App\Services\Sms\SmsService;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaystackController extends Controller
{
    // ---------------
    // Customer return callback - Paystack redirects here with ?reference=
    // ---------------
    public function handleCallback(Request $request)
    {
        $reference = $request->query('reference') ?? $request->query('trxref');

        if (! $reference) {
            return redirect()->route('client.orders.index')
                ->with('error', 'Payment reference missing. If you were charged, please contact support.');
        }

        $order = Order::where('paystack_reference', $reference)->first();

        if (! $order) {
            return redirect()->route('client.orders.index')
                ->with('error', 'We could not match this payment to an order. Please contact support.');
        }

        try {
            $data = app(PaystackService::class)->verifyTransaction($reference);
        } catch (\Throwable $e) {
            Log::error('Paystack verification failed (callback)', [
                'reference' => $reference,
                'error'     => $e->getMessage(),
            ]);

            return redirect()->route('frontend.checkout.payment', ['order' => $order->order_code])
                ->with('error', 'We could not verify your payment yet. It will be confirmed automatically once Paystack notifies us.');
        }

        if (($data['status'] ?? '') === 'success') {
            $this->confirmPaid($order, $reference);

            return redirect()->route('frontend.checkout.payment', ['order' => $order->order_code])
                ->with('success', 'Payment successful! Your order has been confirmed.');
        }

        $this->markFailed($order, $reference, $data['gateway_response'] ?? 'Payment was not completed.');

        return redirect()->route('frontend.checkout.payment', ['order' => $order->order_code])
            ->with('error', 'Your Paystack payment was not completed. You can retry from your orders page.');
    }

    // ---------------
    // Server webhook - charge.success events
    // ---------------
    public function handleWebhook(Request $request)
    {
        $event     = $request->input('event');
        $reference = $request->input('data.reference');

        Log::info('Paystack webhook received', ['event' => $event, 'reference' => $reference]);

        if ($event !== 'charge.success' || ! $reference) {
            return response()->json(['status' => 'ignored']);
        }

        $order = Order::where('paystack_reference', $reference)->first();
        if (! $order) {
            return response()->json(['status' => 'order_not_found']);
        }

        try {
            $data = app(PaystackService::class)->verifyTransaction($reference);
            if (($data['status'] ?? '') === 'success') {
                $this->confirmPaid($order, $reference);
            }
        } catch (\Throwable $e) {
            Log::error('Paystack verification failed (webhook)', [
                'reference' => $reference,
                'error'     => $e->getMessage(),
            ]);
        }

        return response()->json(['status' => 'ok']);
    }

    // ---------------
    // Idempotent post-payment side effects
    // ---------------
    protected function confirmPaid(Order $order, string $reference): void
    {
        $wasNotPaid = $order->payment_status !== 'paid';

        PaymentTransaction::where('is_manual', false)->where('order_id', $order->id)
            ->where('reference', $reference)
            ->update(['status' => 'successful', 'paid_at' => now()]);

        $order->update(['payment_status' => 'paid', 'status' => 'processing']);

        if (! $wasNotPaid) {
            return;
        }

        app(StockService::class)->deductForOrder($order);
        OrderStatusHistory::record($order->id, 'payment_status:paid', 'Payment received via Paystack');

        try {
            $emailService = app(OrderEmailService::class);
            $order->loadMissing(['user', 'items']);
            $emailService->sendPaymentSuccessToClient($order);
        } catch (\Throwable $e) {
            Log::warning('Paystack payment success email failed', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }

        try {
            app(LoyaltyService::class)->earnFromOrder((int) $order->user_id, $order->id, (float) $order->total);
        } catch (\Throwable $e) {
            Log::warning('LoyaltyService::earnFromOrder failed (Paystack)', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }

        try {
            $sms = app(SmsService::class);
            if ($sms->isActive() && $order->phone) {
                $sms->sendOrderUpdate($order->phone, $order->order_code, 'payment received, now processing', (int) $order->user_id);
            }
        } catch (\Throwable $e) {
            Log::warning('Paystack order SMS failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);
        }
    }

    // ---------------
    // Mark a failed attempt
    // ---------------
    protected function markFailed(Order $order, string $reference, string $reason): void
    {
        PaymentTransaction::where('is_manual', false)->where('order_id', $order->id)
            ->where('reference', $reference)
            ->update(['status' => 'failed']);

        if ($order->payment_status !== 'paid') {
            $order->update(['payment_status' => 'failed']);
            OrderStatusHistory::record($order->id, 'payment_status:failed', 'Paystack: ' . $reason);
        }
    }
}
