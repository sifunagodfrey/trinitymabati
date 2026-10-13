<?php

/*
 * Newsletter campaign sending: delivers one campaign email to a
 * single subscriber and reports success or failure to the caller.
 */

namespace App\Services;

use App\Services\Concerns\SendsPlatformEmail;
use Illuminate\Support\Facades\Log;

class NewsletterEmailService
{
    use SendsPlatformEmail;

    // ---------------
    // Holds the last send error so the controller can surface it to the admin
    // ---------------
    public ?string $lastError = null;

    // ---------------
    // Send a newsletter campaign to a single subscriber.
    // Returns true on success, false on failure (caller handles counting).
    // ---------------
    public function sendCampaign(
        string $toEmail,
        string $toName,
        string $subject,
        string $message
    ): bool {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('NewsletterEmailService: no email settings found in su_email_settings.');
            return false;
        }

        // ---------------
        // Empty display name falls back to the local part of the email
        // ---------------
        $resolvedName = $toName !== '' ? $toName : strstr($toEmail, '@', true);

        try {
            $this->send(
                $settings,
                $toEmail,
                $resolvedName,
                $subject,
                'emails.client.newsletter',
                [
                    'subject'     => $subject,
                    'bodyMessage' => $message,
                    'email'       => $toEmail,
                ]
            );
            return true;
        } catch (\Throwable $e) {
            $this->lastError = $e->getMessage();
            Log::warning('NewsletterEmailService: failed to send campaign email', [
                'to'    => $toEmail,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
