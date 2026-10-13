<?php

/* -------------------
   Admin referral program management - referral codes overview, signup
   events, program settings and reward issuing to wallet or loyalty points.
------------------- */

namespace App\Http\Controllers\Manage\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Client\ReferralCode;
use App\Models\Client\ReferralEvent;
use App\Services\LoyaltyService;
use App\Services\WalletService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReferralsController extends Controller
{
    // ---------------
    // List all referral codes with owner and performance stats
    // ---------------
    public function index(): View
    {
        $codes = ReferralCode::with('user:id,first_name,last_name,email')
            ->withCount([
                'events',
                'events as rewarded_events_count' => fn ($q) => $q->where('status', 'rewarded'),
            ])
            ->when(request('search'), function ($q) {
                $search = request('search');
                $q->where('code', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($u) =>
                      $u->where('email', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%"));
            })
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('manage.ecommerce.referrals.index', compact('codes'));
    }

    // ---------------
    // List referral events (signups attributed to referral links)
    // ---------------
    public function events(): View
    {
        $events = ReferralEvent::with([
                'code:id,code',
                'referrer:id,first_name,last_name,email',
                'referred:id,first_name,last_name,email',
            ])
            ->when(request('status'), fn ($q) => $q->where('status', request('status')))
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('manage.ecommerce.referrals.events', compact('events'));
    }

    // ---------------
    // Referral program settings (stored in su_settings)
    // ---------------
    public function settings(): View
    {
        $settings = $this->loadSettings();

        return view('manage.ecommerce.referrals.settings', compact('settings'));
    }

    // ---------------
    // Persist referral program settings
    // ---------------
    public function updateSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'referral_enabled'               => 'required|boolean',
            'referral_reward_type'           => 'required|in:wallet,loyalty_points',
            'referral_reward_value'          => 'required|numeric|min:0',
            'referral_referred_reward_value' => 'required|numeric|min:0',
        ]);

        foreach ([
            'referral_enabled'               => $request->boolean('referral_enabled') ? '1' : '0',
            'referral_reward_type'           => $request->referral_reward_type,
            'referral_reward_value'          => (string) $request->referral_reward_value,
            'referral_referred_reward_value' => (string) $request->referral_referred_reward_value,
        ] as $key => $value) {
            DB::table('su_settings')->updateOrInsert(
                ['setting_key' => $key],
                ['setting_value' => $value, 'updated_at' => now()]
            );
        }

        return redirect()->route('manage.ecommerce.referrals.settings')
            ->with('success', 'Referral settings updated.');
    }

    // ---------------
    // Toggle a referral code on or off
    // ---------------
    public function toggle(string $id): RedirectResponse
    {
        $code = ReferralCode::findOrFail($id);
        $code->update(['is_active' => ! $code->is_active]);

        return back()->with('success', 'Referral code updated.');
    }

    // ---------------
    // Mark a qualified event as rewarded and credit the referrer
    // ---------------
    public function markRewarded(string $id): RedirectResponse
    {
        $event = ReferralEvent::with('code')->findOrFail($id);

        if ($event->status === 'rewarded') {
            return back()->with('error', 'This referral has already been rewarded.');
        }

        $settings = $this->loadSettings();
        $amount   = (float) ($event->code?->reward_value ?: $settings['referral_reward_value']);
        $type     = $event->code?->reward_type ?: $settings['referral_reward_type'];

        if ($amount > 0) {
            if ($type === 'wallet') {
                app(WalletService::class)->credit(
                    $event->referrer_user_id,
                    $amount,
                    'REFERRAL-' . $event->id,
                    'Referral reward'
                );
            } else {
                app(LoyaltyService::class)->award(
                    $event->referrer_user_id,
                    (int) $amount,
                    'Referral reward'
                );
            }
        }

        $event->update([
            'status'        => 'rewarded',
            'reward_amount' => $amount,
            'rewarded_at'   => now(),
        ]);

        return back()->with('success', 'Referral reward issued.');
    }

    // ---------------
    // Load settings with sensible defaults
    // ---------------
    private function loadSettings(): array
    {
        $stored = DB::table('su_settings')
            ->whereIn('setting_key', [
                'referral_enabled',
                'referral_reward_type',
                'referral_reward_value',
                'referral_referred_reward_value',
            ])
            ->pluck('setting_value', 'setting_key');

        return [
            'referral_enabled'               => (bool) ($stored['referral_enabled'] ?? '1'),
            'referral_reward_type'           => $stored['referral_reward_type'] ?? 'wallet',
            'referral_reward_value'          => (float) ($stored['referral_reward_value'] ?? 100),
            'referral_referred_reward_value' => (float) ($stored['referral_referred_reward_value'] ?? 50),
        ];
    }
}
