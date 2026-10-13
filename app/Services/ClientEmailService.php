<?php

/*
 * Client-facing transactional emails: account verification, login,
 * password reset, and order return notifications.
 */

namespace App\Services;

use App\Services\Concerns\SendsPlatformEmail;
use Illuminate\Support\Facades\Log;

class ClientEmailService
{
    use SendsPlatformEmail;

    // ---------------
    // New account registration: send OTP to pending user for email verification
    // ---------------
    public function sendRegistrationOtp(string $email, string $firstName, int $otp): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('ClientEmailService: no email settings found in su_email_settings.');
            return;
        }

        $this->send(
            $settings,
            $email,
            $firstName,
            'Verify Your Trinity Mabati Factory Account',
            'emails.client.new_account_registration',
            ['firstName' => $firstName, 'otp' => $otp]
        );
    }

    // ---------------
    // Login 2FA: send one-time login code to authenticated user
    // ---------------
    public function sendLoginOtp(object $user, int $otp): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('ClientEmailService: no email settings found in su_email_settings.');
            throw new \RuntimeException('Email service is not configured. Please add SMTP credentials in Settings.');
        }

        $this->send(
            $settings,
            $user->email,
            $user->first_name,
            'Your Trinity Mabati Factory Login Verification Code',
            'emails.client.account_login',
            ['user' => $user, 'otp' => $otp]
        );
    }

    // ---------------
    // Forgot password: send reset OTP to verified user
    // ---------------
    public function sendPasswordResetOtp(object $user, int $otp): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('ClientEmailService: no email settings found in su_email_settings.');
            return;
        }

        $this->send(
            $settings,
            $user->email,
            $user->first_name,
            'Trinity Mabati Factory Password Reset Code',
            'emails.client.forgot_password',
            ['user' => $user, 'otp' => $otp]
        );
    }

    // ---------------
    // Order return: notify customer their return request was received
    // ---------------
    public function sendReturnRequested(object $user, object $return, ?object $order, ?object $product): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('ClientEmailService: no email settings found in su_email_settings.');
            return;
        }

        $this->send(
            $settings,
            $user->email,
            $user->first_name,
            'Return Request Received - ' . (optional($order)->order_code ?? '#' . $return->id),
            'emails.client.return_requested',
            ['user' => $user, 'return' => $return, 'order' => $order, 'product' => $product]
        );
    }

    // ---------------
    // Order return: notify customer their return was approved
    // ---------------
    public function sendReturnApproved(object $user, object $return, ?object $order, ?object $product): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('ClientEmailService: no email settings found in su_email_settings.');
            return;
        }

        $this->send(
            $settings,
            $user->email,
            $user->first_name,
            'Your Return Has Been Approved - ' . (optional($order)->order_code ?? '#' . $return->id),
            'emails.client.return_approved',
            ['user' => $user, 'return' => $return, 'order' => $order, 'product' => $product]
        );
    }

    // ---------------
    // Order return: notify customer their return was rejected
    // ---------------
    public function sendReturnRejected(object $user, object $return, ?object $order, ?object $product): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('ClientEmailService: no email settings found in su_email_settings.');
            return;
        }

        $this->send(
            $settings,
            $user->email,
            $user->first_name,
            'Return Request Update - ' . (optional($order)->order_code ?? '#' . $return->id),
            'emails.client.return_rejected',
            ['user' => $user, 'return' => $return, 'order' => $order, 'product' => $product]
        );
    }

    // ---------------
    // Order return: notify customer their refund has been processed
    // ---------------
    public function sendReturnRefunded(object $user, object $return, ?object $order, ?object $product): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('ClientEmailService: no email settings found in su_email_settings.');
            return;
        }

        $this->send(
            $settings,
            $user->email,
            $user->first_name,
            'Refund Processed - ' . (optional($order)->order_code ?? '#' . $return->id),
            'emails.client.return_refunded',
            ['user' => $user, 'return' => $return, 'order' => $order, 'product' => $product]
        );
    }
}
