<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment\Mpesa;
use App\Models\Manage\Payments\PaymentLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    public function mpesaCallback(Request $request)
    {
        $payload = $request->all();

        // Log raw webhook first (using existing su_payment_logs)
        PaymentLog::create([
            'payment_id'       => null,
            'gateway_response' => $payload,
            'status'           => 'webhook_received',
        ]);

        try {
            $mpesa = new Mpesa();
            $mpesa->processCallback($payload);
        } catch (\Exception $e) {
            Log::error('M-Pesa callback error', ['error' => $e->getMessage()]);
        }

        // Always return success to Safaricom
        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
    }
}