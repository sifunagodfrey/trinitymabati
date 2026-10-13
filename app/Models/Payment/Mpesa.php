<?php

namespace App\Models\Payment;

use App\Models\Manage\Payments\PaymentLog;
use App\Models\Manage\Payments\PaymentMethod;
use App\Models\Payment\PaymentTransaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class Mpesa
{
    protected $consumerKey;
    protected $consumerSecret;
    protected $shortcode;
    protected $passkey;
    protected $callbackUrl;
    protected $env;

    public function __construct()
    {
        $this->loadConfig();
    }

    protected function loadConfig()
    {
        $method = PaymentMethod::where('slug', 'mpesa')->active()->first();
        if (!$method) {
            throw new Exception('M-Pesa payment method not found or inactive.');
        }
        $cfg = $method->config;
        $this->consumerKey   = $cfg['consumer_key'] ?? null;
        $this->consumerSecret= $cfg['consumer_secret'] ?? null;
        $this->shortcode     = $cfg['shortcode'] ?? null;
        $this->passkey       = $cfg['passkey'] ?? null;
        $this->callbackUrl   = $cfg['callback_url'] ?? null;
        $this->env           = $cfg['env'] ?? 'production';
    }

    protected function getAccessToken()
    {
        $url = $this->env === 'sandbox'
            ? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
            : 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)
            ->get($url);

        if (!$response->successful()) {
            Log::error('M-Pesa token error', ['response' => $response->body()]);
            throw new Exception('Failed to get access token');
        }
        return $response->json()['access_token'];
    }

    public function stkPush($phone, $amount, $accountRef, $desc = 'Payment')
    {
        $timestamp = now()->format('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        $payload = [
            'BusinessShortCode' => $this->shortcode,
            'Password'          => $password,
            'Timestamp'         => $timestamp,
            'TransactionType'   => 'CustomerPayBillOnline',
            'Amount'            => (int) $amount,
            'PartyA'            => $phone,
            'PartyB'            => $this->shortcode,
            'PhoneNumber'       => $phone,
            'CallBackURL'       => $this->callbackUrl,
            'AccountReference'  => $accountRef,
            'TransactionDesc'   => $desc,
        ];

        $url = $this->env === 'sandbox'
            ? 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest'
            : 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $token = $this->getAccessToken();
        $response = Http::withToken($token)->post($url, $payload);

        if (!$response->successful()) {
            Log::error('STK push failed', ['response' => $response->body()]);
            throw new Exception('STK push request failed');
        }
        return $response->json();
    }

    public function queryStatus($checkoutRequestId)
    {
        $timestamp = now()->format('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        $payload = [
            'BusinessShortCode' => $this->shortcode,
            'Password'          => $password,
            'Timestamp'         => $timestamp,
            'CheckoutRequestID' => $checkoutRequestId,
        ];

        $url = $this->env === 'sandbox'
            ? 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query'
            : 'https://api.safaricom.co.ke/mpesa/stkpushquery/v1/query';

        $token = $this->getAccessToken();
        $response = Http::withToken($token)->post($url, $payload);

        if (!$response->successful()) {
            throw new Exception('Status query failed');
        }
        return $response->json();
    }

    public function processCallback(array $callbackData)
    {
        $body = $callbackData['Body']['stkCallback'] ?? null;
        if (!$body) return false;

        $checkoutId = $body['CheckoutRequestID'];
        $payment = PaymentTransaction::where('reference', $checkoutId)->first();
        if (!$payment) return false;

        if ($body['ResultCode'] == 0) {
            $receipt = null;
            foreach ($body['CallbackMetadata']['Item'] as $item) {
                if ($item['Name'] === 'MpesaReceiptNumber') {
                    $receipt = $item['Value'];
                    break;
                }
            }
            $payment->markSuccessful($receipt);
        } else {
            $payment->markFailed();
        }

        // Log callback
        PaymentLog::create([
            'payment_id'       => $payment->id,
            'gateway_response' => $callbackData,
            'status'           => $body['ResultCode'] == 0 ? 'success' : 'failed',
        ]);

        return true;
    }
}