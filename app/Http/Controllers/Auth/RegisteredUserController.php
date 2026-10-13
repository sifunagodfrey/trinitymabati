<?php

/*
   Handles account registration for the storefront: the signup form,
   optional OTP verification by email or SMS, and creation of the
   customer account and its default role.
*/

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Core\Setting;
use App\Models\User;
use App\Models\Users\UserRole;
use App\Services\CartMergeService;
use App\Services\ClientEmailService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    // ---------------
    // Show Registration Page
    // ---------------
    public function create(): View
    {
        return view('auth.register');
    }

    // ---------------
    // Handle Registration Form - save to pending, send OTP, redirect to verify
    // ---------------
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['nullable', 'string', 'max:100'],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:150', 'unique:su_users,email'],
            'phone'      => ['required', 'string', 'max:15', 'regex:/^\+?[0-9 ]{9,15}$/'],
            'password'   => ['required', 'confirmed', 'min:6'],
        ]);

        // ---------------
        // Signup verification method - configured by the admin under
        // Settings > Login Security. Default: none (no OTP, no email).
        // ---------------
        $method = Setting::get('signup_verification', 'none') ?? 'none';

        if ($method === 'none') {
            return $this->createVerifiedUser($request);
        }

        // ---------------
        // Clear any previous pending attempt for this email
        // ---------------
        DB::table('su_pending_users')->where('email', $request->email)->delete();

        $otp = random_int(100000, 999999);

        DB::table('su_pending_users')->insert([
            'first_name'          => $request->input('first_name'),
            'last_name'           => $request->input('last_name'),
            'email'               => $request->input('email'),
            'phone'               => \App\Services\Sms\SmsService::normalizePhone($request->input('phone')) ?? $request->input('phone'),
            'password_hash'       => bcrypt($request->input('password')),
            'verification_code'   => $otp,
            'expires_at'          => now()->addMinutes(15),
            'resend_available_at' => now()->addMinutes(2),
            'ip_address'          => $request->ip(),
            'user_agent'          => $request->userAgent(),
            'created_at'          => now(),
        ]);

        $emailSent = false;
        $smsSent   = false;

        // ---------------
        // SMS delivery (attempted first when that is the chosen method)
        // ---------------
        if ($method === 'sms') {
            try {
                $sms = app(\App\Services\Sms\SmsService::class);
                if ($sms->isActive()) {
                    $smsSent = (bool) $sms->sendSignupOtp($request->input('phone'), (string) $otp);
                }
            } catch (\Throwable $e) {
                Log::warning('Registration OTP SMS failed', ['error' => $e->getMessage()]);
            }
        }

        // ---------------
        // Email delivery (the method itself, or the fallback when SMS
        // could not be sent) so a misconfigured gateway never blocks signup.
        // ---------------
        if ($method === 'email' || ! $smsSent) {
            try {
                (new ClientEmailService)->sendRegistrationOtp(
                    $request->input('email'),
                    $request->input('first_name'),
                    $otp
                );
                $emailSent = true;
            } catch (\Throwable $e) {
                Log::error('Registration OTP email failed', ['error' => $e->getMessage()]);
            }
        }

        // ---------------
        // If neither channel could deliver the code, do not strand the
        // customer: create the account directly instead of erroring out.
        // ---------------
        if (! $emailSent && ! $smsSent) {
            DB::table('su_pending_users')->where('email', $request->input('email'))->delete();

            return $this->createVerifiedUser($request);
        }

        $request->session()->put('registration_email', $request->input('email'));

        return redirect()->route('register.verify');
    }

    // ---------------
    // Show OTP Verification Page
    // ---------------
    // ---------------
    // Create the customer account directly (no OTP step). Used when the
    // admin has signup verification turned off, and as a graceful fallback
    // when no verification channel is available. Mirrors verify().
    // ---------------
    private function createVerifiedUser(Request $request): RedirectResponse
    {
        $defaultRole = UserRole::where('slug', 'customer')->first();

        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'email'      => $request->input('email'),
            'phone'      => \App\Services\Sms\SmsService::normalizePhone($request->input('phone')) ?? $request->input('phone'),
            'password'   => bcrypt($request->input('password')),
        ]);

        DB::table('su_user_roles')->insert([
            'user_id'    => $user->id,
            'role_id'    => $defaultRole?->id ?? 4,
            'created_at' => now(),
        ]);

        // Attribute referral signup if a valid referral cookie is present
        $referralCookie = $request->cookie('referral_code');
        if ($referralCookie) {
            $referral = \App\Models\Client\ReferralCode::where('code', $referralCookie)
                ->where('is_active', true)
                ->first();

            if ($referral && $referral->user_id !== $user->id) {
                \App\Models\Client\ReferralEvent::firstOrCreate(
                    ['referred_user_id' => $user->id],
                    [
                        'referral_code_id' => $referral->id,
                        'referrer_user_id' => $referral->user_id,
                        'status'           => 'pending',
                        'created_at'       => now(),
                    ]
                );
            }
        }

        event(new Registered($user));

        Auth::login($user);
        CartMergeService::merge($user->id);

        return redirect()->route('client.dashboard');
    }

    public function showVerify(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('registration_email')) {
            return redirect()->route('register');
        }

        return view('auth.verify-registration', [
            'email' => $request->session()->get('registration_email'),
        ]);
    }

    // ---------------
    // Handle OTP Verification - create account on success
    // ---------------
    public function verify(Request $request): RedirectResponse
    {
        $email = $request->session()->get('registration_email');

        if (! $email) {
            return redirect()->route('register');
        }

        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $pending = DB::table('su_pending_users')
            ->where('email', $email)
            ->where('verification_code', $request->input('code'))
            ->first();

        if (! $pending) {
            return back()->withErrors(['code' => 'Invalid verification code. Please check and try again.']);
        }

        if (now()->isAfter($pending->expires_at)) {
            return back()->withErrors(['code' => 'This code has expired. Please start registration again.']);
        }

        // ---------------
        // Resolve default customer role (slug: customer, fallback id: 4)
        // ---------------
        $defaultRole = UserRole::where('slug', 'customer')->first();

        $user = User::create([
            'first_name' => $pending->first_name,
            'last_name'  => $pending->last_name,
            'email'      => $pending->email,
            'phone'      => $pending->phone,
            'password'   => $pending->password_hash,
        ]);

        DB::table('su_user_roles')->insert([
            'user_id'    => $user->id,
            'role_id'    => $defaultRole?->id ?? 4,
            'created_at' => now(),
        ]);

        // ---------------
        // Attribute referral signup if a valid referral cookie is present
        // ---------------
        $referralCookie = request()->cookie('referral_code');
        if ($referralCookie) {
            $referral = \App\Models\Client\ReferralCode::where('code', $referralCookie)
                ->where('is_active', true)
                ->first();

            if ($referral && $referral->user_id !== $user->id) {
                \App\Models\Client\ReferralEvent::firstOrCreate(
                    ['referred_user_id' => $user->id],
                    [
                        'referral_code_id' => $referral->id,
                        'referrer_user_id' => $referral->user_id,
                        'status'           => 'pending',
                        'created_at'       => now(),
                    ]
                );
            }
        }

        DB::table('su_pending_users')->where('id', $pending->id)->delete();

        $request->session()->forget('registration_email');

        event(new Registered($user));

        Auth::login($user);
        CartMergeService::merge($user->id);

        return redirect()->route('client.dashboard');
    }
}
