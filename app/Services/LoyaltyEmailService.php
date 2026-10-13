<?php

/*
 * Loyalty program emails: points earned, points redeemed, points
 * manually adjusted by an admin, and tier change notifications.
 */

namespace App\Services;

use App\Services\Concerns\SendsPlatformEmail;
use Illuminate\Support\Facades\Log;

class LoyaltyEmailService
{
    use SendsPlatformEmail;

    // ---------------
    // Points earned from a purchase, notify the customer
    // ---------------
    public function sendPointsEarned(object $user, int $points, int $newBalance, int $orderId): void
    {
        $settings = $this->emailSettings();
        if (! $settings?->mail_host) {
            Log::warning('LoyaltyEmailService: no email settings found.');
            return;
        }

        $this->send(
            $settings,
            $user->email,
            $user->first_name,
            'You Earned ' . number_format($points) . ' Loyalty Points!',
            'emails.client.loyalty_points_earned',
            ['user' => $user, 'points' => $points, 'newBalance' => $newBalance, 'orderId' => $orderId]
        );
    }

    // ---------------
    // Loyalty tier changed, notify the customer (covers upgrades and downgrades)
    // ---------------
    public function sendTierChanged(object $user, object $oldTier, object $newTier): void
    {
        $settings = $this->emailSettings();
        if (! $settings?->mail_host) {
            Log::warning('LoyaltyEmailService: no email settings found.');
            return;
        }

        $isUpgrade = $newTier->min_points > $oldTier->min_points;
        $subject   = $isUpgrade
            ? 'Congratulations! You\'ve Reached ' . $newTier->name . ' Tier'
            : 'Loyalty Tier Update - You Are Now ' . $newTier->name;

        $this->send(
            $settings,
            $user->email,
            $user->first_name,
            $subject,
            'emails.client.loyalty_tier_changed',
            ['user' => $user, 'oldTier' => $oldTier, 'newTier' => $newTier, 'isUpgrade' => $isUpgrade]
        );
    }

    // ---------------
    // Points manually adjusted by admin, notify the customer
    // ---------------
    public function sendPointsAdjusted(object $user, int $delta, int $newBalance, string $description): void
    {
        $settings = $this->emailSettings();
        if (! $settings?->mail_host) {
            Log::warning('LoyaltyEmailService: no email settings found.');
            return;
        }

        $isAdd   = $delta > 0;
        $subject = $isAdd
            ? number_format(abs($delta)) . ' Loyalty Points Added to Your Account'
            : number_format(abs($delta)) . ' Loyalty Points Deducted from Your Account';

        $this->send(
            $settings,
            $user->email,
            $user->first_name,
            $subject,
            'emails.client.loyalty_points_earned',
            [
                'user'        => $user,
                'points'      => abs($delta),
                'newBalance'  => $newBalance,
                'orderId'     => null,
                'isAdjust'    => true,
                'isAdd'       => $isAdd,
                'description' => $description,
            ]
        );
    }

    // ---------------
    // Points redeemed at checkout, confirm to the customer
    // ---------------
    public function sendPointsRedeemed(object $user, int $points, float $discountAmount, int $orderId): void
    {
        $settings = $this->emailSettings();
        if (! $settings?->mail_host) {
            Log::warning('LoyaltyEmailService: no email settings found.');
            return;
        }

        $this->send(
            $settings,
            $user->email,
            $user->first_name,
            number_format($points) . ' Loyalty Points Redeemed on Your Order',
            'emails.client.loyalty_points_redeemed',
            ['user' => $user, 'points' => $points, 'discountAmount' => $discountAmount, 'orderId' => $orderId]
        );
    }
}
