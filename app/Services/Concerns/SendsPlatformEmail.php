<?php

/*
 * Shared SMTP sending logic for platform email services.
 * Loads connection details from su_email_settings and sends
 * rendered Blade views as HTML email through Laravel's mailer.
 */

namespace App\Services\Concerns;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

trait SendsPlatformEmail
{
    // ---------------
    // Load SMTP credentials from su_email_settings
    // ---------------
    protected function emailSettings(): ?object
    {
        return DB::table('su_email_settings')->orderBy('id', 'desc')->first();
    }

    // ---------------
    // Send one email via SMTP using the stored settings
    // ---------------
    protected function send(
        object $settings,
        string $toEmail,
        string $toName,
        string $subject,
        string $view,
        array  $data
    ): void {
        $html = view($view, $data)->render();

        config([
            'mail.mailers.platform' => [
                'transport'  => $settings->mail_driver ?: 'smtp',
                'host'       => $settings->mail_host,
                'port'       => $settings->mail_port,
                'encryption' => $settings->mail_encryption ?: null,
                'username'   => $settings->mail_username,
                'password'   => $settings->mail_password,
                'timeout'    => null,
            ],
        ]);

        try {
            Mail::mailer('platform')->html($html, function ($message) use ($toEmail, $toName, $subject, $settings) {
                $message->to($toEmail, $toName)
                    ->subject($subject)
                    ->from(
                        $settings->mail_from_address ?: $settings->mail_username,
                        $settings->mail_from_name ?: null
                    );
            });
        } catch (\Throwable $e) {
            Log::warning('Platform email send failed', [
                'to'    => $toEmail,
                'error' => $e->getMessage(),
            ]);
            throw new \RuntimeException('Unable to send email: ' . $e->getMessage());
        }
    }
}
