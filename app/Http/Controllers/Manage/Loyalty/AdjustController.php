<?php

namespace App\Http\Controllers\Manage\Loyalty;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\Loyalty\AdjustPointsRequest;
use App\Models\Manage\Loyalty\LoyaltyPoint;
use App\Models\Manage\Loyalty\LoyaltyTransaction;
use App\Models\Manage\Loyalty\LoyaltyTier;
use App\Models\User;
use App\Services\LoyaltyEmailService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdjustController extends Controller
{
    // ---------------
    // Show Adjust Points Form
    // ---------------
    public function create()
    {
        return view('manage.loyalty.adjust.create');
    }

    // ---------------
    // Apply Manual Point Adjustment
    // Points added: increment points_balance AND lifetime_points, then re-evaluate tier.
    // Points deducted: decrement points_balance only (lifetime never goes down), floor at 0.
    // ---------------
    public function store(AdjustPointsRequest $request)
    {
        $userId  = $request->user_id;
        $amount  = (int) $request->points;
        $isAdd   = $request->adjustment_type === 'add';
        $delta   = $isAdd ? $amount : -$amount;
        $admin   = Auth::user();

        // Captured inside the transaction for post-commit emails
        $emailData = null;

        DB::transaction(function () use ($userId, $amount, $isAdd, $delta, $admin, $request, &$emailData) {

            // ---------------
            // Find or initialise the user's loyalty row
            // ---------------
            $record = LoyaltyPoint::firstOrCreate(
                ['user_id' => $userId],
                ['tier_id' => 1, 'points_balance' => 0, 'lifetime_points' => 0]
            );

            $oldTierId = $record->tier_id;

            // ---------------
            // Update balances
            // ---------------
            $newBalance  = max(0, $record->points_balance + $delta);
            $newLifetime = $isAdd
                ? $record->lifetime_points + $amount
                : $record->lifetime_points;

            // ---------------
            // Re-evaluate tier based on updated lifetime points
            // ---------------
            $newTier = LoyaltyTier::where('is_active', 1)
                ->where('min_points', '<=', $newLifetime)
                ->orderByDesc('min_points')
                ->first();

            $record->update([
                'points_balance'  => $newBalance,
                'lifetime_points' => $newLifetime,
                'tier_id'         => $newTier?->id ?? $record->tier_id,
            ]);

            // ---------------
            // Write audit log entry
            // ---------------
            LoyaltyTransaction::create([
                'user_id'     => $userId,
                'order_id'    => null,
                'type'        => 'adjust',
                'points'      => $delta,
                'description' => $request->description . " (by admin: {$admin->first_name} {$admin->last_name})",
            ]);

            $emailData = [
                'newBalance' => $newBalance,
                'oldTierId'  => $oldTierId,
                'newTier'    => $newTier,
            ];
        });

        // ---------------
        // Send loyalty emails after the transaction commits
        // ---------------
        if ($emailData) {
            $user = User::find($userId);
            if ($user) {
                $loyaltyEmail = app(LoyaltyEmailService::class);

                try {
                    $loyaltyEmail->sendPointsAdjusted(
                        $user,
                        $delta,
                        $emailData['newBalance'],
                        $request->description
                    );
                } catch (\Throwable $e) {
                    Log::warning('LoyaltyEmailService::sendPointsAdjusted failed', [
                        'user_id' => $userId,
                        'error'   => $e->getMessage(),
                    ]);
                }

                if ($emailData['newTier'] && $emailData['newTier']->id !== $emailData['oldTierId']) {
                    $oldTier = LoyaltyTier::find($emailData['oldTierId']);
                    if ($oldTier) {
                        try {
                            $loyaltyEmail->sendTierChanged($user, $oldTier, $emailData['newTier']);
                        } catch (\Throwable $e) {
                            Log::warning('LoyaltyEmailService::sendTierChanged failed', [
                                'user_id' => $userId,
                                'error'   => $e->getMessage(),
                            ]);
                        }
                    }
                }
            }
        }

        return redirect()->route('manage.loyalty.adjust.create')
            ->with('success', 'Points adjusted successfully.');
    }
}
