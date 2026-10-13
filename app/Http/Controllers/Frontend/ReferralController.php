<?php

/* -------------------
   Public referral link handler - records clicks on /ref/{code} links and
   stores the referral cookie used to attribute new signups.
------------------- */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Client\ReferralCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ReferralController extends Controller
{
    // ---------------
    // Public referral link: record the click, remember the code
    // in a cookie for 30 days, then continue to the homepage.
    // ---------------
    public function visit(string $code): RedirectResponse
    {
        $programEnabled = (bool) (DB::table('su_settings')
            ->where('setting_key', 'referral_enabled')
            ->value('setting_value') ?? '1');

        $referral = ReferralCode::where('code', strtoupper($code))
            ->where('is_active', true)
            ->first();

        if (! $programEnabled || ! $referral) {
            return redirect()->route('frontend.home');
        }

        $referral->increment('clicks');

        return redirect()->route('frontend.home')
            ->withCookie(cookie('referral_code', $referral->code, 60 * 24 * 30));
    }
}
