<?php

/* -------------------
   Admin login security settings - choose how customers verify their
   sign-in: no second factor, a code by email, or a code by SMS.
------------------- */

namespace App\Http\Controllers\Manage\Settings;

use App\Http\Controllers\Controller;
use App\Models\Core\Setting;
use App\Services\Sms\SmsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SecurityController extends Controller
{
    // ---------------
    // Settings form
    // ---------------
    public function index(): View
    {
        $method    = Setting::get('login_2fa_method', 'none') ?? 'none';
        $signup    = Setting::get('signup_verification', 'none') ?? 'none';
        $smsActive = (new SmsService())->isActive();

        return view('manage.settings.security.index', compact('method', 'signup', 'smsActive'));
    }

    // ---------------
    // Persist the selected method
    // ---------------
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'login_2fa_method'    => 'required|in:none,email,sms',
            'signup_verification' => 'required|in:none,email,sms',
        ]);

        Setting::put(
            'login_2fa_method',
            $request->input('login_2fa_method'),
            'Customer login verification: none, email or sms'
        );

        Setting::put(
            'signup_verification',
            $request->input('signup_verification'),
            'New account verification: none, email or sms'
        );

        return redirect()->route('manage.settings.security.index')
            ->with('success', 'Login security settings saved.');
    }
}
