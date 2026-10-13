<?php

/* -------------------
   Paystack payment gateway service. Loads credentials from the paystack
   row in su_payment_methods, initializes hosted checkout transactions
   and verifies them by reference after the customer returns.
------------------- */

namespace App\Services\Payment;

use App\Models\Manage\Payments\PaymentMethod;
use Exception;
use Illuminate\Support\Facades\Http;

class PaystackService
{
    protected string $secretKey;
    protected string $publicKey;
    protected string $currency;
    protected string $environment;

    public function __construct()
    {
        $this->loadConfig();
    }

    // ---------------
    // Load Paystack credentials from su_payment_methods
    // ---------------
    protected function loadConfig(): void
    {
        $method = PaymentMethod::where('slug', 'paystack')
            ->where('is_active', true)
            ->first();

        if (! $method || empty($method->config)) {
            throw new Exception('Paystack payment method is not configured or inactive.');
        }

        $config = \is_array($method->config) ? $method->config : json_decode($method->config, true);

        foreach (['secret_key', 'public_key'] as $field) {
            if (empty($config[$field]) || $config[$field] === 'REPLACE_ME') {
                throw new Exception("Paystack config missing required field: {$field}");
            }
        }

        $this->secretKey   = $config['secret_key'];
        $this->publicKey   = $config['public_key'];
        $this->currency    = $config['currency'] ?? 'KES';
        $this->environment = $config['environment'] ?? 'sandbox';
    }

    // ---------------
    // Pre-configured HTTP client. SSL verification is relaxed outside
    // production for local environments without a CA bundle.
    // ---------------
    protected function httpClient(): \Illuminate\Http\Client\PendingRequest
    {
        $client = Http::withToken($this->secretKey)
            ->acceptJson()
            ->timeout(30)
            ->connectTimeout(15);

        if ($this->environment !== 'production') {
            $client = $client->withoutVerifying();
        }

        return $client;
    }

    // ---------------
    // Initialize a hosted checkout transaction.
    // Amount is in major units (KES); Paystack expects the subunit.
    // Returns ['authorization_url' => ..., 'reference' => ...].
    // ---------------
    public function initializeTransaction(string $email, float $amount, string $reference, string $callbackUrl, array $metadata = []): array
    {
        $response = $this->httpClient()->post('https://api.paystack.co/transaction/initialize', [
            'email'        => $email,
            'amount'       => (int) round($amount * 100),
            'currency'     => $this->currency,
            'reference'    => $reference,
            'callback_url' => $callbackUrl,
            'metadata'     => $metadata,
        ]);

        $body = $response->json();

        if (! $response->successful() || ! ($body['status'] ?? false)) {
            throw new Exception('Paystack initialize failed: ' . ($body['message'] ?? $response->body()));
        }

        return [
            'authorization_url' => $body['data']['authorization_url'],
            'access_code'       => $body['data']['access_code'] ?? null,
            'reference'         => $body['data']['reference'],
        ];
    }

    // ---------------
    // Verify a transaction by reference.
    // Returns the Paystack data array; status of 'success' means paid.
    // ---------------
    public function verifyTransaction(string $reference): array
    {
        $response = $this->httpClient()
            ->get('https://api.paystack.co/transaction/verify/' . rawurlencode($reference));

        $body = $response->json();

        if (! $response->successful() || ! ($body['status'] ?? false)) {
            throw new Exception('Paystack verify failed: ' . ($body['message'] ?? $response->body()));
        }

        return $body['data'];
    }
}
