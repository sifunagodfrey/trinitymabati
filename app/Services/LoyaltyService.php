<?php

namespace App\Services;

use App\Models\Manage\Loyalty\LoyaltyPoint;
use App\Models\Manage\Loyalty\LoyaltySetting;
use App\Models\Manage\Loyalty\LoyaltyTier;
use App\Models\Manage\Loyalty\LoyaltyTransaction;
use App\Models\Manage\Loyalty\OrderLoyalty;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LoyaltyService
{
    // ---------------
    // Earn points from a completed order.
    // Idempotent: silently exits if su_order_loyalty already has a record
    // for this order so double-calling from callback + poll is safe.
    // Sends email notifications outside the DB transaction.
    // ---------------
    public function earnFromOrder(int $userId, int $orderId, float $orderTotal): void
    {
        $settings = LoyaltySetting::first();
        if (! $settings || ! $settings->loyalty_enabled) {
            return;
        }

        $kesPerPoint = (float) ($settings->kes_per_point ?? 10);
        if ($kesPerPoint <= 0) {
            return;
        }

        // ---------------
        // Pre-transaction idempotency check (fast path).
        // Check points_earned > 0, not just existence - a redemption row may already
        // exist for this order before earning runs (redemption happens at order creation,
        // earning happens later when payment is confirmed).
        // ---------------
        if (OrderLoyalty::where('order_id', $orderId)->where('user_id', $userId)->where('points_earned', '>', 0)->exists()) {
            return;
        }

        $pointsEarned = 0;
        $newBalance   = 0;
        $oldTierId    = null;
        $newTierId    = null;

        try {
            DB::transaction(function () use (
                $userId, $orderId, $orderTotal, $kesPerPoint,
                &$pointsEarned, &$newBalance, &$oldTierId, &$newTierId
            ) {
                // ---------------
                // Re-check inside transaction with lock - same points_earned guard as above
                // ---------------
                if (OrderLoyalty::where('order_id', $orderId)->where('user_id', $userId)->where('points_earned', '>', 0)->lockForUpdate()->exists()) {
                    return;
                }

                $record = LoyaltyPoint::where('user_id', $userId)->lockForUpdate()->first();
                if (! $record) {
                    $record = LoyaltyPoint::create([
                        'user_id'         => $userId,
                        'tier_id'         => 1,
                        'points_balance'  => 0,
                        'lifetime_points' => 0,
                    ]);
                }

                $multiplier   = (float) (LoyaltyTier::find($record->tier_id)?->points_multiplier ?? 1.0);
                $pointsEarned = max(1, (int) floor(($orderTotal / $kesPerPoint) * $multiplier));
                $newBalance   = $record->points_balance + $pointsEarned;
                $newLifetime  = $record->lifetime_points + $pointsEarned;
                $oldTierId    = $record->tier_id;

                // ---------------
                // Re-evaluate tier after earning
                // ---------------
                $newTier   = LoyaltyTier::where('is_active', 1)
                    ->where('min_points', '<=', $newLifetime)
                    ->orderByDesc('min_points')
                    ->first();
                $newTierId = $newTier?->id ?? $oldTierId;

                $record->update([
                    'points_balance'  => $newBalance,
                    'lifetime_points' => $newLifetime,
                    'tier_id'         => $newTierId,
                ]);

                LoyaltyTransaction::create([
                    'user_id'     => $userId,
                    'order_id'    => $orderId,
                    'type'        => 'earn',
                    'points'      => $pointsEarned,
                    'description' => 'Points earned from order #' . $orderId,
                ]);

                // ---------------
                // Update existing redemption row if present (order had loyalty discount),
                // otherwise create a fresh row.
                // ---------------
                $existingLoyalty = OrderLoyalty::where('order_id', $orderId)->where('user_id', $userId)->first();
                if ($existingLoyalty) {
                    $existingLoyalty->update(['points_earned' => $pointsEarned]);
                } else {
                    OrderLoyalty::create([
                        'order_id'        => $orderId,
                        'user_id'         => $userId,
                        'points_earned'   => $pointsEarned,
                        'points_redeemed' => 0,
                        'discount_amount' => 0,
                    ]);
                }
            });
        } catch (\Throwable $e) {
            Log::error('LoyaltyService: earnFromOrder failed', [
                'user_id'  => $userId,
                'order_id' => $orderId,
                'error'    => $e->getMessage(),
            ]);
            return;
        }

        if ($pointsEarned <= 0) {
            return;
        }

        // ---------------
        // Email notifications - outside the transaction so they never trigger a rollback
        // ---------------
        try {
            $user = User::find($userId);
            if (! $user) {
                return;
            }

            $emailService = app(LoyaltyEmailService::class);
            $emailService->sendPointsEarned($user, $pointsEarned, $newBalance, $orderId);

            if ($newTierId && $oldTierId && $newTierId !== $oldTierId) {
                $oldTier = LoyaltyTier::find($oldTierId);
                $newTier = LoyaltyTier::find($newTierId);
                if ($oldTier && $newTier) {
                    $emailService->sendTierChanged($user, $oldTier, $newTier);
                }
            }
        } catch (\Throwable $e) {
            Log::warning('LoyaltyService: post-earn email failed', [
                'user_id'  => $userId,
                'order_id' => $orderId,
                'error'    => $e->getMessage(),
            ]);
        }
    }

    // ---------------
    // Award points outside the order flow (e.g. referral rewards).
    // Creates the loyalty record when missing and logs a transaction.
    // ---------------
    public function award(int $userId, int $points, string $description): void
    {
        if ($points <= 0) {
            return;
        }

        try {
            DB::transaction(function () use ($userId, $points, $description) {
                $record = LoyaltyPoint::where('user_id', $userId)->lockForUpdate()->first();
                if (! $record) {
                    $record = LoyaltyPoint::create([
                        'user_id'         => $userId,
                        'tier_id'         => 1,
                        'points_balance'  => 0,
                        'lifetime_points' => 0,
                    ]);
                }

                $newLifetime = $record->lifetime_points + $points;

                $newTier = LoyaltyTier::where('is_active', 1)
                    ->where('min_points', '<=', $newLifetime)
                    ->orderByDesc('min_points')
                    ->first();

                $record->update([
                    'points_balance'  => $record->points_balance + $points,
                    'lifetime_points' => $newLifetime,
                    'tier_id'         => $newTier?->id ?? $record->tier_id,
                ]);

                LoyaltyTransaction::create([
                    'user_id'     => $userId,
                    'order_id'    => null,
                    'type'        => 'earn',
                    'points'      => $points,
                    'description' => $description,
                ]);
            });
        } catch (\Throwable $e) {
            Log::error('LoyaltyService: award failed', [
                'user_id' => $userId,
                'points'  => $points,
                'error'   => $e->getMessage(),
            ]);
        }
    }

    // ---------------
    // Redeem points against a completed order.
    // $points = number of loyalty points redeemed.
    // $discountAmount = KES value subtracted from the order total.
    // ---------------
    public function redeemForOrder(int $userId, int $orderId, int $points, float $discountAmount): void
    {
        if ($points <= 0) {
            return;
        }

        try {
            DB::transaction(function () use ($userId, $orderId, $points, $discountAmount) {
                $record = LoyaltyPoint::where('user_id', $userId)->lockForUpdate()->first();
                if (! $record || $record->points_balance < $points) {
                    throw new \RuntimeException('Insufficient loyalty points balance.');
                }

                $record->decrement('points_balance', $points);

                LoyaltyTransaction::create([
                    'user_id'     => $userId,
                    'order_id'    => $orderId,
                    'type'        => 'redeem',
                    'points'      => -$points,
                    'description' => 'Points redeemed on order #' . $orderId,
                ]);

                // ---------------
                // Update or create the order loyalty row
                // ---------------
                $existing = OrderLoyalty::where('order_id', $orderId)->where('user_id', $userId)->first();
                if ($existing) {
                    $existing->update([
                        'points_redeemed' => $existing->points_redeemed + $points,
                        'discount_amount' => $existing->discount_amount + $discountAmount,
                    ]);
                } else {
                    OrderLoyalty::create([
                        'order_id'        => $orderId,
                        'user_id'         => $userId,
                        'points_earned'   => 0,
                        'points_redeemed' => $points,
                        'discount_amount' => $discountAmount,
                    ]);
                }
            });
        } catch (\Throwable $e) {
            Log::error('LoyaltyService: redeemForOrder failed', [
                'user_id'  => $userId,
                'order_id' => $orderId,
                'error'    => $e->getMessage(),
            ]);
            return;
        }

        // ---------------
        // Email notification - outside the transaction
        // ---------------
        try {
            $user = User::find($userId);
            if ($user) {
                app(LoyaltyEmailService::class)->sendPointsRedeemed($user, $points, $discountAmount, $orderId);
            }
        } catch (\Throwable $e) {
            Log::warning('LoyaltyService: post-redeem email failed', [
                'user_id'  => $userId,
                'order_id' => $orderId,
                'error'    => $e->getMessage(),
            ]);
        }
    }
}
