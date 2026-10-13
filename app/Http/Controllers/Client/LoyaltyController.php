<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Manage\Loyalty\LoyaltyPoint;
use App\Models\Manage\Loyalty\LoyaltySetting;
use App\Models\Manage\Loyalty\LoyaltyTier;
use App\Models\Manage\Loyalty\LoyaltyTransaction;
use Illuminate\Support\Facades\Auth;

class LoyaltyController extends Controller
{
    // ---------------
    // Loyalty Overview - tier, balances, next-tier progress, recent activity
    // ---------------
    public function index()
    {
        $userId   = Auth::id();
        $settings = LoyaltySetting::firstOrCreate(
            ['id' => 1],
            ['loyalty_enabled' => 1, 'kes_per_point' => 10, 'redemption_rate' => 10, 'min_redeem_points' => 100]
        );

        $record = LoyaltyPoint::with('tier')
            ->where('user_id', $userId)
            ->first();

        // ---------------
        // Build next-tier data for the progress bar
        // ---------------
        $nextTier = null;
        $progress = 100;

        if ($record) {
            $nextTier = LoyaltyTier::where('is_active', 1)
                ->where('min_points', '>', $record->lifetime_points)
                ->orderBy('min_points')
                ->first();

            if ($nextTier) {
                $currentMin = $record->tier->min_points ?? 0;
                $range      = $nextTier->min_points - $currentMin;
                $earned     = $record->lifetime_points - $currentMin;
                $progress   = $range > 0 ? min(100, (int) round(($earned / $range) * 100)) : 100;
            }
        }

        $recentTransactions = LoyaltyTransaction::where('user_id', $userId)
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        return view('client.loyalty.index', compact(
            'settings',
            'record',
            'nextTier',
            'progress',
            'recentTransactions'
        ));
    }

    // ---------------
    // Full Paginated Transaction History
    // ---------------
    public function history()
    {
        $userId       = Auth::id();
        $transactions = LoyaltyTransaction::where('user_id', $userId)
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('client.loyalty.history', compact('transactions'));
    }

    // ---------------
    // Redeem Points Page - informational; actual redemption is applied at checkout
    // ---------------
    public function showRedeem()
    {
        $userId   = Auth::id();
        $settings = LoyaltySetting::firstOrCreate(['id' => 1]);
        $record   = LoyaltyPoint::where('user_id', $userId)->first();

        return view('client.loyalty.redeem', compact('settings', 'record'));
    }
}
