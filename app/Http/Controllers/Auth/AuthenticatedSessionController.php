<?php

/*
   Handles authentication for the storefront: showing the login form,
   validating credentials, optional two factor verification, and
   session teardown on logout.
*/

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\VerifyTwoFaRequest;
use App\Models\Core\Setting;
use App\Models\User;
use App\Services\CartMergeService;
use App\Services\ClientEmailService;
use App\Services\Sms\SmsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    // ---------------
    // Show the login form
    // ---------------
    public function create(): View
    {
        return view('auth.login');
    }

    // ---------------
    // Handle login form submission.
    // Validates credentials, then initiates 2FA instead of immediately logging in.
    // ---------------
    public function store(LoginRequest $request): RedirectResponse
    {
        // ---------------
        // Rate limiting - reuse the throttle logic from LoginRequest
        // ---------------
        $request->ensureIsNotRateLimited();

        $user = User::where('email', $request->email)->with('role')->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            RateLimiter::hit($request->throttleKey());
            return back()
                ->withErrors(['email' => trans('auth.failed')])
                ->withInput(['email' => $request->email]);
        }

        RateLimiter::clear($request->throttleKey());

        // ---------------
        // Block inactive accounts
        // ---------------
        if ($user->status !== 'active') {
            return back()
                ->withErrors(['email' => 'Your account is not active.'])
                ->withInput(['email' => $request->email]);
        }

        // ---------------
        // Admin roles must use the admin login at /manage/login
        // ---------------
        $slug = $user->role?->slug;

        if (in_array($slug, ['super_admin', 'admin'], true)) {
            return back()
                ->withErrors(['email' => trans('auth.failed')])
                ->withInput(['email' => $request->email]);
        }

        // ---------------
        // Login verification method - configured by the admin under
        // Settings > Login Security. Default: no second factor.
        // ---------------
        $method = Setting::get('login_2fa_method', 'none') ?? 'none';

        if ($method === 'none') {
            return $this->completeLogin($request, $user, $request->boolean('remember'));
        }

        // ---------------
        // Generate 2FA code and persist it
        // ---------------
        $otp       = random_int(100000, 999999);
        $expiresAt = now()->addMinutes(10)->format('Y-m-d H:i:s');

        DB::table('su_users')
            ->where('id', $user->id)
            ->update(['twofa_code' => $otp, 'twofa_expires_at' => $expiresAt]);

        // ---------------
        // Deliver the code. SMS is attempted first when selected and the
        // user has a phone number; otherwise (or on SMS failure) the code
        // falls back to email so nobody gets locked out.
        // ---------------
        $sentVia = null;

        if ($method === 'sms') {
            $sms   = new SmsService();
            $phone = SmsService::normalizePhone($user->phone);

            if ($phone && $sms->isActive()) {
                $message = 'Your Trinity Mabati Factory login code is ' . $otp . '. It expires in 10 minutes.';

                if ($sms->send($phone, $message, 'login_otp', $user->id)) {
                    $sentVia = 'phone ending ' . substr($phone, -3);
                }
            }
        }

        if ($sentVia === null) {
            try {
                (new ClientEmailService())->sendLoginOtp($user, $otp);
                $sentVia = $user->email;
            } catch (\Throwable $e) {
                DB::table('su_users')
                    ->where('id', $user->id)
                    ->update(['twofa_code' => null, 'twofa_expires_at' => null]);

                return back()
                    ->withErrors(['email' => 'Failed to send verification code: ' . $e->getMessage()])
                    ->withInput(['email' => $request->email]);
            }
        }

        // ---------------
        // Store partial auth state (including remember preference) and redirect to 2FA page
        // ---------------
        $request->session()->put('twofa_user_id', $user->id);
        $request->session()->put('twofa_remember', $request->boolean('remember'));

        return redirect()->route('login.verify2fa')
            ->with('success', 'Verification code sent to ' . $sentVia . '.');
    }

    // ---------------
    // Finish authentication: log in, regenerate the session, apply the
    // sliding remember window and send the user to their dashboard.
    // Shared by the no-2FA path and kept consistent with verify().
    // ---------------
    private function completeLogin(Request $request, User $user, bool $remember): RedirectResponse
    {
        Auth::login($user, $remember);
        CartMergeService::merge($user->id);
        $request->session()->regenerate();

        if ($remember) {
            $minutes = 43200;
            $request->session()->put('session_expires_at', now()->addMinutes($minutes)->toDateTimeString());
            $request->session()->put('session_remember_minutes', $minutes);
        }

        return redirect()->intended(route('client.dashboard'));
    }

    // ---------------
    // Show the 2FA verification form.
    // ---------------
    public function showVerify(Request $request): View|RedirectResponse
    {
        if (!$request->session()->has('twofa_user_id')) {
            return redirect()->route('login');
        }

        return view('auth.verify-2fa');
    }

    // ---------------
    // Verify the 2FA code and complete authentication.
    // Redirects to the correct dashboard based on the user's role.
    // ---------------
    public function verify(VerifyTwoFaRequest $request): RedirectResponse
    {
        $userId = $request->session()->get('twofa_user_id');

        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::with('role')->find($userId);

        if (!$user) {
            $request->session()->forget('twofa_user_id');
            return redirect()->route('login')
                ->withErrors(['code' => 'Session expired. Please log in again.']);
        }

        // ---------------
        // Verify code and expiry
        // ---------------
        $record = DB::table('su_users')
            ->where('id', $userId)
            ->select('twofa_code', 'twofa_expires_at')
            ->first();

        $codeMatch  = $record && (string) $record->twofa_code === $request->code;
        $notExpired = $record?->twofa_expires_at && now()->lte($record->twofa_expires_at);

        if (!$codeMatch || !$notExpired) {
            return back()->withErrors(['code' => 'Invalid or expired verification code.']);
        }

        // ---------------
        // Consume the code so it cannot be reused
        // ---------------
        DB::table('su_users')
            ->where('id', $userId)
            ->update(['twofa_code' => null, 'twofa_expires_at' => null]);

        $remember = (bool) $request->session()->pull('twofa_remember', false);
        $request->session()->forget('twofa_user_id');

        Auth::login($user, $remember);
        CartMergeService::merge($user->id);
        $request->session()->regenerate();

        // ---------------
        // Redirect to the correct portal based on role
        // ---------------
        $slug = $user->role?->slug;

        // ---------------
        // If remembered, enforce sliding session duration: 30 days
        // ---------------
        if ($remember) {
            $minutes = 43200;
            $request->session()->put('session_expires_at', now()->addMinutes($minutes)->toDateTimeString());
            $request->session()->put('session_remember_minutes', $minutes);
        }

        return redirect()->intended(route('client.dashboard'));
    }

    // ---------------
    // Logout
    // ---------------
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
