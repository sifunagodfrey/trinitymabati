<?php

/*
 * Wallet emails: top-up success and failure, wallet debit on
 * purchase, and withdrawal request confirmation.
 */

namespace App\Services;

use App\Services\Concerns\SendsPlatformEmail;
use Illuminate\Support\Facades\Log;

class WalletEmailService
{
    use SendsPlatformEmail;

    // ---------------
    // Top-up succeeded, notify the customer with the new balance
    // ---------------
    public function sendTopupSuccess(object $user, float $amount, float $newBalance, string $reference): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('WalletEmailService: no email settings found in su_email_settings.');
            return;
        }

        $this->send(
            $settings,
            $user->email,
            $user->first_name,
            'Wallet Top-Up Successful - KES ' . number_format($amount, 2),
            'emails.client.wallet_topup_success',
            ['user' => $user, 'amount' => $amount, 'newBalance' => $newBalance, 'reference' => $reference]
        );
    }

    // ---------------
    // Top-up failed, notify the customer to retry
    // ---------------
    public function sendTopupFailed(object $user, float $amount, string $reason): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('WalletEmailService: no email settings found in su_email_settings.');
            return;
        }

        $this->send(
            $settings,
            $user->email,
            $user->first_name,
            'Wallet Top-Up Failed',
            'emails.client.wallet_topup_failed',
            ['user' => $user, 'amount' => $amount, 'reason' => $reason]
        );
    }

    // ---------------
    // Wallet used to pay for an order, notify the customer of the debit
    // ---------------
    public function sendWalletPurchase(object $user, float $amount, float $newBalance, string $orderCode): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('WalletEmailService: no email settings found in su_email_settings.');
            return;
        }

        $this->send(
            $settings,
            $user->email,
            $user->first_name,
            'Wallet Payment Confirmed - Order ' . $orderCode,
            'emails.client.wallet_purchase_debit',
            ['user' => $user, 'amount' => $amount, 'newBalance' => $newBalance, 'orderCode' => $orderCode]
        );
    }

    // ---------------
    // Withdrawal request received, confirm to the customer
    // ---------------
    public function sendWithdrawSubmitted(object $user, float $amount, string $method): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('WalletEmailService: no email settings found in su_email_settings.');
            return;
        }

        $this->send(
            $settings,
            $user->email,
            $user->first_name,
            'Withdrawal Request Received - KES ' . number_format($amount, 2),
            'emails.client.wallet_withdraw_submitted',
            ['user' => $user, 'amount' => $amount, 'method' => $method]
        );
    }
}
