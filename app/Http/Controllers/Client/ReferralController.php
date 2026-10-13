<?php

/* -------------------
   Customer referral dashboard - personal referral link, click and signup
   stats, link regeneration and pausing.
------------------- */

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client\ReferralCode;
use App\Models\Client\ReferralEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReferralController extends Controller
{
    // ---------------
    // Referral dashboard: link, clicks, signups and rewards
    // ---------------
    public function index(): View
    {
        $userId = Auth::id();

        $code = ReferralCode::firstOrCreate(
            ['user_id' => $userId],
            ['code' => ReferralCode::generateUniqueCode(), 'is_active' => true]
        );

        $events = ReferralEvent::with('referred:id,first_name,last_name,created_at')
            ->where('referrer_user_id', $userId)
            ->orderByDesc('id')
            ->paginate(10);

        $stats = [
            'clicks'   => $code->clicks,
            'signups'  => ReferralEvent::where('referrer_user_id', $userId)->count(),
            'rewarded' => ReferralEvent::where('referrer_user_id', $userId)->where('status', 'rewarded')->count(),
            'earned'   => (float) ReferralEvent::where('referrer_user_id', $userId)
                ->where('status', 'rewarded')->sum('reward_amount'),
        ];

        $programEnabled = (bool) (DB::table('su_settings')
            ->where('setting_key', 'referral_enabled')
            ->value('setting_value') ?? '1');

        return view('client.referrals.index', compact('code', 'events', 'stats', 'programEnabled'));
    }

    // ---------------
    // Regenerate the personal referral code
    // ---------------
    public function generate(): RedirectResponse
    {
        $code = ReferralCode::firstOrCreate(
            ['user_id' => Auth::id()],
            ['code' => ReferralCode::generateUniqueCode(), 'is_active' => true]
        );

        $code->update(['code' => ReferralCode::generateUniqueCode()]);

        return redirect()->route('client.referrals.index')
            ->with('success', 'A new referral link has been generated.');
    }

    // ---------------
    // Toggle the personal referral link on or off
    // ---------------
    public function toggle(): RedirectResponse
    {
        $code = ReferralCode::where('user_id', Auth::id())->firstOrFail();
        $code->update(['is_active' => ! $code->is_active]);

        return redirect()->route('client.referrals.index')
            ->with('success', $code->is_active ? 'Referral link activated.' : 'Referral link paused.');
    }
}
