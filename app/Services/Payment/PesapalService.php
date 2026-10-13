<?php

/* -------------------
   Pesapal API 3.0 payment gateway service. Loads credentials from the
   pesapal row in su_payment_methods, authenticates for a bearer token,
   registers the IPN URL, submits order requests for hosted checkout and
   queries transaction status by tracking id.
------------------- */

namespace App\Services\Payment;

use App\Models\Manage\Payments\PaymentMethod;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PesapalService
{
    protected string $consumerKey;
    protected string $consumerSecret;
    protected string $environment;
    protected string $currency;
    protected string $baseUrl;
    protected ?string $ipnUrl;

    public function __construct()
    {
        $this->loadConfig();
    }

    // ---------------
    // Load Pesapal credentials from su_payment_methods
    // ---------------
    protected function loadConfig(): void
    {
        $method = PaymentMethod::where('slug', 'pesapal')
            ->where('is_active', true)
            ->first();

        if (! $method || empty($method->config)) {
            throw new Exception('Pesapal payment method is not configured or inactive.');
        }

        $config = \is_array($method->config) ? $method->config : json_decode($method->config, true);

        foreach (['consumer_key', 'consumer_secret'] as $field) {
            if (empty($config[$field]) || $config[$field] === 'REPLACE_ME') {
                throw new Exception("Pesapal config missing required field: {$field}");
            }
        }

        $this->consumerKey    = $config['consumer_key'];
        $this->consumerSecret = $config['consumer_secret'];
        $this->environment    = $config['environment'] ?? 'sandbox';
        $this->currency       = $config['currency'] ?? 'KES';
        $this->ipnUrl         = $config['ipn_url'] ?? null;

        $this->baseUrl = $this->environment === 'production'
            ? 'https://pay.pesapal.com/v3'
            : 'https://cybqa.pesapal.com/pesapalv3';
    }

    // ---------------
    // Pre-configured HTTP client
    // ---------------
    protected function httpClient(): \Illuminate\Http\Client\PendingRequest
    {
        $client = Http::acceptJson()->timeout(30)->connectTimeout(15);

        if ($this->environment !== 'production') {
            $client = $client->withoutVerifying();
        }

        return $client;
    }

    // ---------------
    // Authenticate and return a bearer token (cached ~4 minutes;
    // Pesapal tokens expire after 5).
    // ---------------
    public function getAccessToken(): string
    {
        $cacheKey = 'pesapal_token_' . md5($this->consumerKey . $this->environment);

        return Cache::remember($cacheKey, 240, function () {
            $response = $this->httpClient()->post($this->baseUrl . '/api/Auth/RequestToken', [
                'consumer_key'    => $this->consumerKey,
                'consumer_secret' => $this->consumerSecret,
            ]);

            $body = $response->json();

            if (! $response->successful() || empty($body['token'])) {
                throw new Exception('Pesapal auth failed: ' . ($body['error']['message'] ?? $response->body()));
            }

            return $body['token'];
        });
    }

    // ---------------
    // Register (or fetch) the IPN URL and return its notification id.
    // The id is cached per URL since registration is idempotent.
    // ---------------
    public function getNotificationId(string $ipnUrl): string
    {
        $cacheKey = 'pesapal_ipn_' . md5($ipnUrl . $this->environment);

        return Cache::remember($cacheKey, 86400, function () use ($ipnUrl) {
            $response = $this->httpClient()
                ->withToken($this->getAccessToken())
                ->post($this->baseUrl . '/api/URLSetup/RegisterIPN', [
                    'url'                   => $ipnUrl,
                    'ipn_notification_type' => 'GET',
                ]);

            $body = $response->json();

            if (! $response->successful() || empty($body['ipn_id'])) {
                throw new Exception('Pesapal IPN registration failed: ' . ($body['error']['message'] ?? $response->body()));
            }

            return $body['ipn_id'];
        });
    }

    // ---------------
    // Submit an order request for hosted checkout.
    // Returns ['order_tracking_id' => ..., 'redirect_url' => ...].
    // ---------------
    public function submitOrder(
        string $merchantReference,
        float  $amount,
        string $description,
        string $callbackUrl,
        string $email,
        ?string $phone = null,
        ?string $firstName = null,
        ?string $lastName = null
    ): array {
        $ipnUrl         = $this->ipnUrl && $this->ipnUrl !== 'REPLACE_ME' ? $this->ipnUrl : $callbackUrl;
        $notificationId = $this->getNotificationId($ipnUrl);

        $payload = [
            'id'              => $merchantReference,
            'currency'        => $this->currency,
            'amount'          => round($amount, 2),
            'description'     => mb_substr($description, 0, 100),
            'callback_url'    => $callbackUrl,
            'notification_id' => $notificationId,
            'billing_address' => array_filter([
                'email_address' => $email,
                'phone_number'  => $phone,
                'first_name'    => $firstName,
                'last_name'     => $lastName,
                'country_code'  => 'KE',
            ]),
        ];

        $response = $this->httpClient()
            ->withToken($this->getAccessToken())
            ->post($this->baseUrl . '/api/Transactions/SubmitOrderRequest', $payload);

        $body = $response->json();

        if (! $response->successful() || empty($body['redirect_url'])) {
            throw new Exception('Pesapal order submission failed: ' . ($body['error']['message'] ?? $response->body()));
        }

        return [
            'order_tracking_id' => $body['order_tracking_id'],
            'redirect_url'      => $body['redirect_url'],
        ];
    }

    // ---------------
    // Query a transaction status by order tracking id.
    // payment_status_description: COMPLETED, FAILED, REVERSED or INVALID.
    // ---------------
    public function getTransactionStatus(string $orderTrackingId): array
    {
        $response = $this->httpClient()
            ->withToken($this->getAccessToken())
            ->get($this->baseUrl . '/api/Transactions/GetTransactionStatus', [
                'orderTrackingId' => $orderTrackingId,
            ]);

        $body = $response->json();

        if (! $response->successful()) {
            throw new Exception('Pesapal status query failed: ' . ($body['error']['message'] ?? $response->body()));
        }

        return $body;
    }
}
