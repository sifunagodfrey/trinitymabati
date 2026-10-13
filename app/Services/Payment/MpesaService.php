<?php

namespace App\Services\Payment;

use App\Models\Payment\PendingMpesa;
use App\Models\Payment\PendingWalletMpesa;
use App\Models\Manage\Payments\PaymentMethod;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    protected string $consumerKey;
    protected string $consumerSecret;
    protected string $shortcode;
    protected string $passkey;
    protected string $callbackUrl;
    protected string $environment; // 'sandbox' or 'production'
    protected ?string $accessToken = null;

    // ---------------
    // Constructor - loads config from database
    // ---------------
    public function __construct()
    {
        $this->loadConfig();
    }

    /**
     * Load Mpesa credentials from su_payment_methods table
     *
     * @throws Exception
     */
    protected function loadConfig(): void
    {
        $method = PaymentMethod::where('slug', 'mpesa')
            ->where('is_active', true)
            ->first();

        if (!$method || empty($method->config)) {
            throw new Exception('Mpesa payment method is not configured or inactive.');
        }

        $config = \is_array($method->config) ? $method->config : json_decode($method->config, true);

        $required = ['consumer_key', 'consumer_secret', 'shortcode', 'passkey', 'callback_url', 'env'];
        foreach ($required as $field) {
            if (empty($config[$field])) {
                throw new Exception("Mpesa config missing required field: {$field}");
            }
        }

        $this->consumerKey = $config['consumer_key'];
        $this->consumerSecret = $config['consumer_secret'];
        $this->shortcode = $config['shortcode'];
        $this->passkey = $config['passkey'];
        $this->callbackUrl = $config['callback_url'];
        $this->environment = $config['env'];
    }

    // ---------------
    // Build a pre-configured Http client with timeout and SSL options.
    // SSL verification is disabled on sandbox/dev to avoid cURL error 28
    // (SSL handshake timeout) on local environments like XAMPP that lack a
    // CA bundle. In production, the CA chain is validated normally.
    // ---------------
    protected function httpClient(): \Illuminate\Http\Client\PendingRequest
    {
        $client = Http::timeout(30)->connectTimeout(15);

        if ($this->environment !== 'production') {
            $client = $client->withoutVerifying();
        }

        return $client;
    }

    // ---------------
    // Get OAuth token from Mpesa API
    // ---------------
    protected function getAccessToken(): string
    {
        if ($this->accessToken) {
            return $this->accessToken;
        }

        $url = $this->getBaseUrl() . '/oauth/v1/generate?grant_type=client_credentials';

        $response = $this->httpClient()
            ->withBasicAuth($this->consumerKey, $this->consumerSecret)
            ->get($url);

        if (!$response->successful()) {
            Log::error('Mpesa OAuth failed', ['response' => $response->body()]);
            throw new Exception('Failed to obtain Mpesa access token.');
        }

        $data = $response->json();
        $this->accessToken = $data['access_token'] ?? null;

        if (!$this->accessToken) {
            throw new Exception('Mpesa access token missing in response.');
        }

        return $this->accessToken;
    }

    // ---------------
    // Send authenticated request to Mpesa API
    // ---------------
    protected function sendRequest(string $endpoint, array $payload): array
    {
        $token = $this->getAccessToken();
        $url = $this->getBaseUrl() . $endpoint;

        $response = $this->httpClient()
            ->withToken($token)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url, $payload);

        if (!$response->successful()) {
            Log::error('Mpesa API request failed', [
                'endpoint' => $endpoint,
                'payload' => $payload,
                'response' => $response->body(),
            ]);
            throw new Exception('Mpesa API request failed: ' . $response->body());
        }

        return $response->json() ?? [];
    }

    // ---------------
    // Get base URL based on environment
    // ---------------
    protected function getBaseUrl(): string
    {
        return $this->environment === 'production'
            ? 'https://api.safaricom.co.ke'
            : 'https://sandbox.safaricom.co.ke';
    }

    // ---------------
    // Format phone number to 254XXXXXXXXX
    // ---------------
    protected function formatPhoneNumber(string $phone): string
    {
        // Remove any non-digit characters
        $phone = preg_replace('/\D/', '', $phone);

        // If starts with 0, replace with 254
        if (substr($phone, 0, 1) === '0') {
            $phone = '254' . substr($phone, 1);
        }
        return $phone;
    }

    // ---------------
    // Initiate STK Push
    // ---------------
    public function initiateStkPush(string $phone, float $amount, string $orderReference, int $orderId): array
    {
        $phone = $this->formatPhoneNumber($phone);
        $amount = (int) round($amount); // Mpesa expects integer

        $timestamp = now()->format('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        $payload = [
            'BusinessShortCode' => $this->shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => $this->shortcode,
            'PhoneNumber' => $phone,
            'CallBackURL' => $this->callbackUrl,
            'AccountReference' => $orderReference,
            'TransactionDesc' => "Payment for {$orderReference}",
        ];

        $response = $this->sendRequest('/mpesa/stkpush/v1/processrequest', $payload);

        // Save pending transaction record
        PendingMpesa::create([
            'checkout_request_id' => $response['CheckoutRequestID'] ?? null,
            'phone' => $phone,
            'amount' => $amount,
            'user_id' => auth()->id() ?? 0,
            'order_id' => $orderId,
        ]);

        return $response;
    }

    // ---------------
    // Query STK Push status (optional)
    // ---------------
    public function queryStatus(string $checkoutRequestId): array
    {
        $timestamp = now()->format('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        $payload = [
            'BusinessShortCode' => $this->shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'CheckoutRequestID' => $checkoutRequestId,
        ];

        return $this->sendRequest('/mpesa/stkpushquery/v1/query', $payload);
    }

    // ---------------
    // Initiate Mpesa STK push for a wallet top-up.
    // Saves the tracking record to su_pending_wallet_mpesa (not su_pending_mpesa)
    // so the callback can distinguish wallet flows from order flows.
    // ---------------
    public function initiateWalletTopup(string $phone, float $amount, int $userId): array
    {
        $phone     = $this->formatPhoneNumber($phone);
        $amount    = (int) round($amount);
        $timestamp = now()->format('YmdHis');
        $password  = base64_encode($this->shortcode . $this->passkey . $timestamp);
        $ref       = 'WAL-' . $userId . '-' . $timestamp;

        $payload = [
            'BusinessShortCode' => $this->shortcode,
            'Password'          => $password,
            'Timestamp'         => $timestamp,
            'TransactionType'   => 'CustomerPayBillOnline',
            'Amount'            => $amount,
            'PartyA'            => $phone,
            'PartyB'            => $this->shortcode,
            'PhoneNumber'       => $phone,
            'CallBackURL'       => $this->callbackUrl,
            'AccountReference'  => $ref,
            'TransactionDesc'   => 'Trinity Mabati Factory Wallet Top-Up',
        ];

        $response = $this->sendRequest('/mpesa/stkpush/v1/processrequest', $payload);

        PendingWalletMpesa::create([
            'user_id'             => $userId,
            'checkout_request_id' => $response['CheckoutRequestID'] ?? null,
            'amount'              => $amount,
            'phone'               => $phone,
            'status'              => 'pending',
        ]);

        return $response;
    }
}