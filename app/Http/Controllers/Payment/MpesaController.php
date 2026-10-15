<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Order;
use App\Models\Manage\Payments\PaymentLog;
use App\Models\Manage\Payments\PaymentMethod;
use App\Models\Payment\PaymentTransaction;
use App\Models\Client\Wallet;
use App\Models\Payment\PendingMpesa;
use App\Models\Payment\PendingWalletMpesa;
use App\Models\User;
use App\Services\LoyaltyService;
use App\Services\OrderEmailService;
use App\Services\Payment\MpesaService;
use App\Services\WalletEmailService;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MpesaController extends Controller
{
    protected MpesaService $mpesaService;

    public function __construct(MpesaService $mpesaService)
    {
        $this->mpesaService = $mpesaService;
    }

    public function initiateStkPush(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'order_id' => 'required|integer|exists:su_orders,id',
        ]);

        $order = Order::findOrFail($request->order_id);

        if (auth()->check() && $order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $response = $this->mpesaService->initiateStkPush(
                $request->phone,
                $order->total,
                'ORD' . $order->order_code,
                $order->id
            );

            return response()->json([
                'success' => true,
                'message' => 'STK push sent. Enter your PIN on your phone.',
                'checkout_request_id' => $response['CheckoutRequestID'] ?? null,
                'response' => $response,
            ]);
        } catch (\Exception $e) {
            Log::error('STK Push initiation failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function pollingScreen(Request $request)
    {
        $orderCode = $request->query('order');
        $cid       = $request->query('cid');

        if (! $orderCode || ! $cid) {
            return redirect()->route('frontend.checkout');
        }

        return view('frontend.checkout.mpesa-polling', [
            'orderCode' => $orderCode,
            'cid'       => $cid,
        ]);
    }

    public function pollStatus(Request $request)
    {
        $request->validate(['cid' => 'required|string']);

        $cid = $request->query('cid');

        $transaction = PaymentTransaction::with('logs')->where('is_manual', false)
            ->where('reference', $cid)
            ->where('user_id', auth()->id())
            ->first();

        if (! $transaction) {
            return response()->json(['status' => 'pending']);
        }

        if (in_array($transaction->status, ['successful', 'failed'])) {
            $payload = ['status' => $transaction->status];

            if ($transaction->status === 'failed') {
                $log     = $transaction->logs->first();
                $gateway = $log?->gateway_response ?? [];
                $payload['reason'] = $gateway['Body']['stkCallback']['ResultDesc'] ?? 'Payment was not completed.';
            }

            return response()->json($payload);
        }

        try {
            $result     = $this->mpesaService->queryStatus($cid);
            $resultCode = $result['ResultCode'] ?? null;
            $resultDesc = $result['ResultDesc'] ?? 'Payment was not completed.';

            if ($resultCode === 0 || $resultCode === '0') {
                $transaction->update(['status' => 'successful', 'paid_at' => now()]);

                $order = Order::find($transaction->order_id);
                if ($order) {
                    $wasNotPaid = $order->payment_status !== 'paid';
                    $order->update(['payment_status' => 'paid', 'status' => 'processing']);

                    if ($wasNotPaid) {
                        app(\App\Services\StockService::class)->deductForOrder($order);
                        \App\Models\Manage\Ecommerce\OrderStatusHistory::record(
                            $order->id, 'payment_status:paid', 'Payment received via M-Pesa'
                        );
                    }

                    if ($wasNotPaid) {
                        try {
                            $emailService = app(OrderEmailService::class);
                            $order->loadMissing(['user', 'items']);
                            $emailService->sendPaymentSuccessToClient($order);
                        } catch (\Throwable $e) {
                            Log::warning('Payment success email failed (poll)', [
                                'order_id' => $order->id,
                                'error'    => $e->getMessage(),
                            ]);
                        }

                        // Award loyalty points for the purchase (M-Pesa poll)
                        try {
                            app(LoyaltyService::class)->earnFromOrder(
                                $order->user_id,
                                $order->id,
                                (float) $order->total
                            );
                        } catch (\Throwable $e) {
                            Log::warning('LoyaltyService::earnFromOrder failed (Mpesa poll)', [
                                'order_id' => $order->id,
                                'error'    => $e->getMessage(),
                            ]);
                        }
                    }
                }

                PendingMpesa::where('checkout_request_id', $cid)->delete();

                return response()->json(['status' => 'successful']);
            }

            if (str_contains(strtolower((string) $resultDesc), 'being processed')
                || str_contains(strtolower((string) $resultDesc), 'transaction is pending')) {
                return response()->json(['status' => 'pending']);
            }

            $transaction->refresh();
            if ($transaction->status === 'successful') {
                return response()->json(['status' => 'successful']);
            }

            $definitiveFailureCodes = ['1032', '2001', '1019', '1037'];

            if (! in_array((string) $resultCode, $definitiveFailureCodes)) {
                return response()->json(['status' => 'pending']);
            }

            $transaction->update(['status' => 'failed']);

            $order = Order::find($transaction->order_id);
            if ($order) {
                $wasNotFailed = $order->payment_status !== 'failed';
                $order->update(['payment_status' => 'failed']);

                if ($wasNotFailed) {
                    try {
                        app(OrderEmailService::class)->sendPaymentFailedToClient($order, $resultDesc);
                    } catch (\Throwable $e) {
                        Log::warning('Payment failed email failed (poll)', [
                            'order_id' => $order->id,
                            'error'    => $e->getMessage(),
                        ]);
                    }
                }
            }

            PaymentLog::create([
                'payment_id'       => $transaction->id,
                'gateway_response' => $result,
                'status'           => 'failed',
            ]);

            PendingMpesa::where('checkout_request_id', $cid)->delete();

            return response()->json(['status' => 'failed', 'reason' => $resultDesc]);

        } catch (\Throwable $e) {
            Log::warning('Mpesa direct status query failed during polling', [
                'cid'   => $cid,
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json(['status' => 'pending']);
    }

    public function handleCallback(Request $request)
    {
        $callbackData = $request->getContent();
        Log::info('Mpesa Callback received', json_decode($callbackData, true) ?: []);

        $body = json_decode($callbackData, true);
        $result = $body['Body']['stkCallback'] ?? [];

        $checkoutRequestId = $result['CheckoutRequestID'] ?? null;
        $resultCode = $result['ResultCode'] ?? 1;
        $resultDesc = $result['ResultDesc'] ?? 'Unknown error';

        if (!$checkoutRequestId) {
            Log::error('Mpesa callback missing CheckoutRequestID', ['body' => $body]);
            return response()->json(['message' => 'Invalid callback data'], 400);
        }

        $pending = PendingMpesa::where('checkout_request_id', $checkoutRequestId)->first();
        if (!$pending) {
            return $this->handleWalletMpesaCallback($checkoutRequestId, $resultCode, $resultDesc, $body);
        }

        $transaction   = PaymentTransaction::where('is_manual', false)->where('reference', $checkoutRequestId)->first();
        $paymentMethod = PaymentMethod::where('slug', 'mpesa')->first();

        if ($resultCode == 0) {
            $metadata           = $result['CallbackMetadata']['Item'] ?? [];
            $mpesaReceiptNumber = null;

            foreach ($metadata as $item) {
                if ($item['Name'] === 'MpesaReceiptNumber') {
                    $mpesaReceiptNumber = $item['Value'];
                }
            }

            if ($transaction) {
                $transaction->update([
                    'status'    => 'successful',
                    'reference' => $mpesaReceiptNumber ?: $checkoutRequestId,
                    'paid_at'   => now(),
                ]);
            } else {
                $transaction = PaymentTransaction::create([
                    'user_id'   => $pending->user_id,
                    'order_id'  => $pending->order_id,
                    'amount'    => $pending->amount,
                    'method_id' => $paymentMethod?->id,
                    'status'    => 'successful',
                    'reference' => $mpesaReceiptNumber ?: $checkoutRequestId,
                    'paid_at'   => now(),
                ]);
            }

            PaymentLog::create([
                'payment_id'       => $transaction->id,
                'gateway_response' => $body,
                'status'           => 'success',
            ]);

            $order = Order::find($pending->order_id);
            if ($order) {
                $wasNotPaid = $order->payment_status !== 'paid';
                $order->payment_status = 'paid';
                $order->status         = 'processing';
                $order->save();

                if ($wasNotPaid) {
                    app(\App\Services\StockService::class)->deductForOrder($order);
                    \App\Models\Manage\Ecommerce\OrderStatusHistory::record(
                        $order->id, 'payment_status:paid', 'Payment received via M-Pesa'
                    );
                }

                if ($wasNotPaid) {
                    try {
                        $emailService = app(OrderEmailService::class);
                        $order->loadMissing(['user', 'items']);
                        $emailService->sendPaymentSuccessToClient($order);
                    } catch (\Throwable $e) {
                        Log::warning('Payment success email failed (callback)', [
                            'order_id' => $order->id,
                            'error'    => $e->getMessage(),
                        ]);
                    }

                    // Award loyalty points for the purchase (M-Pesa callback)
                    try {
                        app(LoyaltyService::class)->earnFromOrder(
                            $order->user_id,
                            $order->id,
                            (float) $order->total
                        );
                    } catch (\Throwable $e) {
                        Log::warning('LoyaltyService::earnFromOrder failed (Mpesa callback)', [
                            'order_id' => $order->id,
                            'error'    => $e->getMessage(),
                        ]);
                    }
                }
            }

            $pending->delete();

            Log::info('Mpesa payment successful', [
                'order_id' => $pending->order_id,
                'receipt'  => $mpesaReceiptNumber,
            ]);
        } else {
            if ($transaction) {
                $transaction->update(['status' => 'failed']);
            } else {
                $transaction = PaymentTransaction::create([
                    'user_id'   => $pending->user_id,
                    'order_id'  => $pending->order_id,
                    'amount'    => $pending->amount,
                    'method_id' => $paymentMethod?->id,
                    'status'    => 'failed',
                    'reference' => $checkoutRequestId,
                ]);
            }

            PaymentLog::create([
                'payment_id'       => $transaction->id,
                'gateway_response' => $body,
                'status'           => 'failed',
            ]);

            $order = Order::find($pending->order_id);
            if ($order) {
                $wasNotFailed = $order->payment_status !== 'failed';
                $order->payment_status = 'failed';
                $order->save();

                if ($wasNotFailed) {
                    try {
                        app(OrderEmailService::class)->sendPaymentFailedToClient($order, $resultDesc);
                    } catch (\Throwable $e) {
                        Log::warning('Payment failed email failed (callback)', [
                            'order_id' => $order->id,
                            'error'    => $e->getMessage(),
                        ]);
                    }
                }
            }

            $pending->delete();

            Log::warning('Mpesa payment failed', [
                'checkoutRequestId' => $checkoutRequestId,
                'resultCode'        => $resultCode,
                'resultDesc'        => $resultDesc,
            ]);
        }

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'OK']);
    }

    public function reportTimeout(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate(['cid' => 'required|string']);

        $cid = $request->input('cid');

        $transaction = PaymentTransaction::where('is_manual', false)->where('reference', $cid)
            ->where('user_id', auth()->id())
            ->first();

        if (! $transaction || $transaction->status !== 'pending') {
            return response()->json(['recorded' => false]);
        }

        $transaction->update(['status' => 'failed']);

        $pending = PendingMpesa::where('checkout_request_id', $cid)->first();
        $orderId = $pending?->order_id ?? $transaction->order_id;

        $order = Order::find($orderId);
        if ($order) {
            $wasNotFailed = $order->payment_status !== 'failed';
            $order->update(['payment_status' => 'failed']);

            if ($wasNotFailed) {
                try {
                    app(OrderEmailService::class)->sendPaymentFailedToClient(
                        $order,
                        'Your payment timed out. No confirmation was received from M-Pesa. Please retry payment from your order dashboard.'
                    );
                } catch (\Throwable $e) {
                    Log::warning('Payment timeout email failed', [
                        'order_id' => $order->id,
                        'error'    => $e->getMessage(),
                    ]);
                }
            }
        }

        PaymentLog::create([
            'payment_id'       => $transaction->id,
            'gateway_response' => ['timeout' => true, 'cid' => $cid],
            'status'           => 'failed',
        ]);

        $pending?->delete();

        Log::warning('Mpesa payment timed out on polling screen', ['cid' => $cid]);

        return response()->json(['recorded' => true]);
    }

    private function handleWalletMpesaCallback(
        string $checkoutRequestId,
        int|string $resultCode,
        string $resultDesc,
        array $body
    ): \Illuminate\Http\JsonResponse {
        $walletPending = PendingWalletMpesa::where('checkout_request_id', $checkoutRequestId)
            ->where('status', 'pending')
            ->first();

        if (! $walletPending) {
            Log::warning('Mpesa callback: no pending record found (order or wallet)', [
                'checkoutRequestId' => $checkoutRequestId,
            ]);
            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'OK']);
        }

        if ($resultCode == 0) {
            $metadata           = $body['Body']['stkCallback']['CallbackMetadata']['Item'] ?? [];
            $mpesaReceiptNumber = null;
            foreach ($metadata as $item) {
                if ($item['Name'] === 'MpesaReceiptNumber') {
                    $mpesaReceiptNumber = $item['Value'];
                }
            }
            $receipt = $mpesaReceiptNumber ?: $checkoutRequestId;

            $walletPending->refresh();
            if ($walletPending->status === 'completed') {
                return response()->json(['ResultCode' => 0, 'ResultDesc' => 'OK']);
            }

            try {
                app(WalletService::class)->credit(
                    $walletPending->user_id,
                    (float) $walletPending->amount,
                    $receipt,
                    'Top-up via M-Pesa'
                );
                $walletPending->update(['status' => 'completed']);

                try {
                    $user       = User::find($walletPending->user_id);
                    $newBalance = (float) Wallet::where('user_id', $walletPending->user_id)->value('balance');
                    if ($user) {
                        app(WalletEmailService::class)->sendTopupSuccess(
                            $user,
                            (float) $walletPending->amount,
                            $newBalance,
                            $receipt
                        );
                    }
                } catch (\Throwable $e) {
                    Log::warning('Wallet top-up success email failed (Mpesa callback)', [
                        'user_id' => $walletPending->user_id,
                        'error'   => $e->getMessage(),
                    ]);
                }

                Log::info('Mpesa wallet top-up successful via callback', [
                    'user_id' => $walletPending->user_id,
                    'receipt' => $receipt,
                ]);
            } catch (\Throwable $e) {
                Log::error('Mpesa wallet top-up credit failed in callback', [
                    'user_id' => $walletPending->user_id,
                    'error'   => $e->getMessage(),
                ]);
            }
        } else {
            $walletPending->update(['status' => 'failed']);

            try {
                $user = User::find($walletPending->user_id);
                if ($user) {
                    app(WalletEmailService::class)->sendTopupFailed(
                        $user,
                        (float) $walletPending->amount,
                        $resultDesc
                    );
                }
            } catch (\Throwable $e) {
                Log::warning('Wallet top-up failed email failed (Mpesa callback)', [
                    'user_id' => $walletPending->user_id,
                    'error'   => $e->getMessage(),
                ]);
            }

            Log::warning('Mpesa wallet top-up failed via callback', [
                'user_id'    => $walletPending->user_id,
                'resultCode' => $resultCode,
                'resultDesc' => $resultDesc,
            ]);
        }

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'OK']);
    }
}