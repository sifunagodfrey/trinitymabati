<?php

/* -------------------
   Pesapal payment controller. Handles the customer return callback and
   the IPN notification: queries the transaction status by tracking id,
   marks the order paid, deducts stock, records the timeline and awards
   loyalty points.
------------------- */

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Order;
use App\Models\Manage\Ecommerce\OrderStatusHistory;
use App\Models\Payment\PaymentTransaction;
use App\Models\Payment\PendingPesapal;
use App\Services\LoyaltyService;
use App\Services\OrderEmailService;
use App\Services\Payment\PesapalService;
use App\Services\Sms\SmsService;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PesapalController extends Controller
{
    // ---------------
    // Customer return callback - Pesapal redirects here with
    // ?OrderTrackingId= and ?OrderMerchantReference=
    // ---------------
    public function handleCallback(Request $request)
    {
        $trackingId = $request->query('OrderTrackingId');

        if (! $trackingId) {
            return redirect()->route('client.orders.index')
                ->with('error', 'Payment reference missing. If you were charged, please contact support.');
        }

        $pending = PendingPesapal::where('order_tracking_id', $trackingId)->first();
        $order   = $pending?->order_id ? Order::find($pending->order_id) : null;

        if (! $order) {
            return redirect()->route('client.orders.index')
                ->with('error', 'We could not match this payment to an order. Please contact support.');
        }

        $result = $this->processStatus($trackingId, $pending, $order);

        if ($result === 'paid') {
            return redirect()->route('frontend.checkout.payment', ['order' => $order->order_code])
                ->with('success', 'Payment successful! Your order has been confirmed.');
        }

        if ($result === 'failed') {
            return redirect()->route('frontend.checkout.payment', ['order' => $order->order_code])
                ->with('error', 'Your Pesapal payment was not completed. You can retry from your orders page.');
        }

        return redirect()->route('frontend.checkout.payment', ['order' => $order->order_code])
            ->with('info', 'Your payment is still being processed. We will confirm it automatically shortly.');
    }

    // ---------------
    // IPN notification - Pesapal calls this server to server with
    // OrderTrackingId and OrderNotificationType
    // ---------------
    public function handleIpn(Request $request)
    {
        $trackingId = $request->input('OrderTrackingId') ?? $request->query('OrderTrackingId');

        Log::info('Pesapal IPN received', ['tracking_id' => $trackingId]);

        if (! $trackingId) {
            return response()->json(['status' => 'missing_tracking_id'], 400);
        }

        $pending = PendingPesapal::where('order_tracking_id', $trackingId)->first();
        $order   = $pending?->order_id ? Order::find($pending->order_id) : null;

        if ($pending) {
            $pending->update(['ipn_payload' => json_encode($request->all())]);
        }

        if ($order) {
            $this->processStatus($trackingId, $pending, $order);
        }

        return response()->json([
            'orderNotificationType' => $request->input('OrderNotificationType', 'IPNCHANGE'),
            'orderTrackingId'       => $trackingId,
            'orderMerchantReference'=> $pending->merchant_reference ?? null,
            'status'                => 200,
        ]);
    }

    // ---------------
    // Query Pesapal and apply the result. Returns 'paid', 'failed' or 'pending'.
    // ---------------
    protected function processStatus(string $trackingId, ?PendingPesapal $pending, Order $order): string
    {
        try {
            $status = app(PesapalService::class)->getTransactionStatus($trackingId);
        } catch (\Throwable $e) {
            Log::error('Pesapal status query failed', [
                'tracking_id' => $trackingId,
                'error'       => $e->getMessage(),
            ]);

            return 'pending';
        }

        $description = strtoupper((string) ($status['payment_status_description'] ?? ''));

        if ($description === 'COMPLETED') {
            $pending?->update(['status' => 'completed']);
            $this->confirmPaid($order, $trackingId);

            return 'paid';
        }

        if (in_array($description, ['FAILED', 'INVALID', 'REVERSED'])) {
            $pending?->update(['status' => strtolower($description)]);
            $this->markFailed($order, $trackingId, $status['description'] ?? $description);

            return 'failed';
        }

        return 'pending';
    }

    // ---------------
    // Idempotent post-payment side effects
    // ---------------
    protected function confirmPaid(Order $order, string $trackingId): void
    {
        $wasNotPaid = $order->payment_status !== 'paid';

        PaymentTransaction::where('is_manual', false)->where('order_id', $order->id)
            ->where('reference', $trackingId)
            ->update(['status' => 'successful', 'paid_at' => now()]);

        $order->update(['payment_status' => 'paid', 'status' => 'processing']);

        if (! $wasNotPaid) {
            return;
        }

        app(StockService::class)->deductForOrder($order);
        OrderStatusHistory::record($order->id, 'payment_status:paid', 'Payment received via Pesapal');

        try {
            $emailService = app(OrderEmailService::class);
            $order->loadMissing(['user', 'items']);
            $emailService->sendPaymentSuccessToClient($order);
        } catch (\Throwable $e) {
            Log::warning('Pesapal payment success email failed', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }

        try {
            app(LoyaltyService::class)->earnFromOrder((int) $order->user_id, $order->id, (float) $order->total);
        } catch (\Throwable $e) {
            Log::warning('LoyaltyService::earnFromOrder failed (Pesapal)', [
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
            Log::warning('Pesapal order SMS failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);
        }
    }

    // ---------------
    // Mark a failed attempt
    // ---------------
    protected function markFailed(Order $order, string $trackingId, string $reason): void
    {
        PaymentTransaction::where('is_manual', false)->where('order_id', $order->id)
            ->where('reference', $trackingId)
            ->update(['status' => 'failed']);

        if ($order->payment_status !== 'paid') {
            $order->update(['payment_status' => 'failed']);
            OrderStatusHistory::record($order->id, 'payment_status:failed', 'Pesapal: ' . $reason);
        }
    }
}
