<?php

/* -------------------
   SMS service using the Africa's Talking messaging API. Loads credentials
   from su_sms_settings, normalizes Kenyan phone numbers, sends messages
   and records every attempt in su_sms_logs.
------------------- */

namespace App\Services\Sms;

use App\Models\Manage\System\SmsLog;
use App\Models\Manage\System\SmsSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected ?SmsSetting $settings = null;

    public function __construct()
    {
        $this->settings = SmsSetting::orderByDesc('id')->first();
    }

    // ---------------
    // Whether SMS sending is configured and switched on
    // ---------------
    public function isActive(): bool
    {
        return $this->settings
            && $this->settings->is_active
            && $this->settings->api_key
            && $this->settings->api_key !== 'REPLACE_ME'
            && $this->settings->username
            && $this->settings->username !== 'REPLACE_ME';
    }

    // ---------------
    // Normalize a Kenyan phone number to +2547XXXXXXXX format.
    // Accepts 07XX, 7XX, 2547XX and +2547XX inputs.
    // ---------------
    public static function normalizePhone(?string $phone): ?string
    {
        if (! $phone) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $phone);

        if (str_starts_with($digits, '254') && strlen($digits) === 12) {
            return '+' . $digits;
        }
        if (str_starts_with($digits, '0') && strlen($digits) === 10) {
            return '+254' . substr($digits, 1);
        }
        if ((str_starts_with($digits, '7') || str_starts_with($digits, '1')) && strlen($digits) === 9) {
            return '+254' . $digits;
        }

        return strlen($digits) >= 9 ? '+' . $digits : null;
    }

    // ---------------
    // Send an SMS and log the attempt.
    // $type is a short tag used for filtering logs, e.g. 'signup_otp',
    // 'order_update', 'low_stock', 'test'.
    // Returns true when the provider accepted the message.
    // ---------------
    public function send(string $phone, string $message, string $type = 'general', ?int $userId = null): bool
    {
        $normalized = static::normalizePhone($phone);

        $log = SmsLog::create([
            'user_id'    => $userId,
            'phone'      => $normalized ?? $phone,
            'type'       => $type,
            'message'    => $message,
            'status'     => 'queued',
            'created_at' => now(),
        ]);

        if (! $this->isActive()) {
            $log->update(['status' => 'skipped', 'error' => 'SMS sending is disabled or not configured.']);
            return false;
        }

        if (! $normalized) {
            $log->update(['status' => 'failed', 'error' => 'Invalid phone number format.']);
            return false;
        }

        $endpoint = $this->settings->environment === 'production'
            ? 'https://api.africastalking.com/version1/messaging'
            : 'https://api.sandbox.africastalking.com/version1/messaging';

        try {
            $payload = [
                'username' => $this->settings->username,
                'to'       => $normalized,
                'message'  => $message,
            ];

            if ($this->settings->sender_id && $this->settings->sender_id !== 'REPLACE_ME') {
                $payload['from'] = $this->settings->sender_id;
            }

            $client = Http::asForm()
                ->withHeaders([
                    'apiKey' => $this->settings->api_key,
                    'Accept' => 'application/json',
                ])
                ->timeout(20);

            if ($this->settings->environment !== 'production') {
                $client = $client->withoutVerifying();
            }

            $response  = $client->post($endpoint, $payload);
            $body      = $response->json();
            $recipient = $body['SMSMessageData']['Recipients'][0] ?? null;
            $accepted  = $recipient && (int) ($recipient['statusCode'] ?? 0) === 101;

            $log->update([
                'status'              => $accepted ? 'sent' : 'failed',
                'provider_message_id' => $recipient['messageId'] ?? null,
                'cost'                => $recipient['cost'] ?? null,
                'error'               => $accepted ? null : json_encode($body),
            ]);

            return $accepted;
        } catch (\Throwable $e) {
            Log::warning('SmsService: send failed', [
                'phone' => $normalized,
                'type'  => $type,
                'error' => $e->getMessage(),
            ]);
            $log->update(['status' => 'failed', 'error' => $e->getMessage()]);

            return false;
        }
    }

    // ---------------
    // Convenience helpers for the common message types
    // ---------------
    public function sendSignupOtp(string $phone, string $code, ?int $userId = null): bool
    {
        $message = 'Your ' . config('app.name', 'Trinity Mabati Factory') . ' verification code is ' . $code
            . '. It expires in 15 minutes. Do not share this code with anyone.';

        return $this->send($phone, $message, 'signup_otp', $userId);
    }

    public function sendOrderUpdate(string $phone, string $orderCode, string $statusLine, ?int $userId = null): bool
    {
        $message = config('app.name', 'Trinity Mabati Factory') . ': Order ' . $orderCode . ' update - ' . $statusLine
            . '. Track it in your account.';

        return $this->send($phone, $message, 'order_update', $userId);
    }

    public function sendLowStockAlert(string $phone, string $productName, int $stock): bool
    {
        $message = config('app.name', 'Trinity Mabati Factory') . ' stock alert: "' . $productName
            . '" is low (' . $stock . ' left). Restock soon.';

        return $this->send($phone, $message, 'low_stock');
    }
}
