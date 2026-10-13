<?php

/*
 * System-facing transactional emails: admin password reset, login 2FA,
 * and system user account lifecycle notifications.
 */

namespace App\Services;

use App\Services\Concerns\SendsPlatformEmail;
use Illuminate\Support\Facades\Log;

class AdminEmailService
{
    use SendsPlatformEmail;

    // ---------------
    // Admin forgot password: send OTP reset code to the admin user
    // ---------------
    public function sendPasswordResetOtp(object $user, int $otp): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('AdminEmailService: no email settings found in su_email_settings.');
            throw new \RuntimeException('Email service is not configured. Please add SMTP credentials in Settings.');
        }

        $this->send(
            $settings,
            $user->email,
            $user->first_name,
            'Trinity Mabati Factory Admin Panel - Password Reset Code',
            'emails.system.admin_forgot_password',
            ['user' => $user, 'otp' => $otp]
        );
    }

    // ---------------
    // Admin login 2FA: send verification code to the admin user
    // ---------------
    public function sendLoginOtp(object $user, int $otp): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('AdminEmailService: no email settings found in su_email_settings.');
            throw new \RuntimeException('Email service is not configured. Please add SMTP credentials in Settings.');
        }

        $this->send(
            $settings,
            $user->email,
            $user->first_name,
            'Trinity Mabati Factory Admin Verification Code',
            'emails.system.admin_login_2fa',
            ['user' => $user, 'otp' => $otp]
        );
    }

    // ---------------
    // Send email to system user when account is created (includes plain password)
    // ---------------
    public function sendUserCreatedEmail(object $user, string $plainPassword): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('AdminEmailService: no email settings, cannot send user creation email.');
            return;
        }

        $this->send(
            $settings,
            $user->email,
            $user->first_name,
            'Welcome to Trinity Mabati Factory Admin Panel - Your Account Details',
            'emails.system.user_created',
            ['user' => $user, 'password' => $plainPassword]
        );
    }

    // ---------------
    // Send email to system user when account is updated, includes list of changes
    // ---------------
    public function sendUserUpdatedEmail(object $user, array $changes): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('AdminEmailService: no email settings, cannot send user update email.');
            return;
        }

        $this->send(
            $settings,
            $user->email,
            $user->first_name,
            'Your Trinity Mabati Factory Account Has Been Updated',
            'emails.system.user_updated',
            ['user' => $user, 'changes' => $changes]
        );
    }

    // ---------------
    // Send email to system user when account is deleted (soft delete)
    // ---------------
    public function sendUserDeletedEmail(object $user): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('AdminEmailService: no email settings, cannot send user deletion email.');
            return;
        }

        $this->send(
            $settings,
            $user->email,
            $user->first_name,
            'Your Trinity Mabati Factory Admin Account Has Been Deleted',
            'emails.system.user_deleted',
            ['user' => $user]
        );
    }
}
