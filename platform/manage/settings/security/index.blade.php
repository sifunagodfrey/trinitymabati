{{-- -------------------
     Admin Login Security Settings
     Choose the second factor used when customers sign in
------------------- --}}
@extends('manage.layouts.app')

@section('title', 'Login Security - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.settings.security.index') }}" class="hover:text-primary">Settings</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Login Security</li>
            </ol>
        </nav>

        <div>
            <h1 class="text-2xl font-semibold text-black">Login Security</h1>
            <p class="text-sm text-muted">Choose whether a verification code is required at sign-in. Applies to both the customer login and this admin login.</p>
        </div>
    </div>

    {{-- ---------------
    -- Alerts
    -- --------------- --}}
    @if (session('success'))
        <div class="mb-6 rounded-[12px] border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('manage.settings.security.update') }}">
        @csrf

        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm mb-6 space-y-4">
            <h2 class="text-lg font-semibold text-black">Login Verification</h2>
            <p class="text-sm text-muted -mt-2">Controls whether a code is required when an existing customer signs in.</p>

            {{-- No 2FA --}}
            <label class="flex items-start gap-3 rounded-[12px] border p-4 cursor-pointer transition
                {{ $method === 'none' ? 'border-primary bg-primary/5' : 'border-border bg-white hover:border-primary/40' }}">
                <input type="radio" name="login_2fa_method" value="none" {{ $method === 'none' ? 'checked' : '' }}
                       class="mt-1 accent-primary">
                <span>
                    <span class="block text-sm font-semibold text-black">No verification (default)</span>
                    <span class="block text-xs text-muted mt-0.5">Everyone signs in with just their email and password.</span>
                </span>
            </label>

            {{-- Email 2FA --}}
            <label class="flex items-start gap-3 rounded-[12px] border p-4 cursor-pointer transition
                {{ $method === 'email' ? 'border-primary bg-primary/5' : 'border-border bg-white hover:border-primary/40' }}">
                <input type="radio" name="login_2fa_method" value="email" {{ $method === 'email' ? 'checked' : '' }}
                       class="mt-1 accent-primary">
                <span>
                    <span class="block text-sm font-semibold text-black">Email verification</span>
                    <span class="block text-xs text-muted mt-0.5">A 6-digit code is emailed after the password is accepted. Requires email settings to be configured.</span>
                </span>
            </label>

            {{-- SMS 2FA --}}
            <label class="flex items-start gap-3 rounded-[12px] border p-4 cursor-pointer transition
                {{ $method === 'sms' ? 'border-primary bg-primary/5' : 'border-border bg-white hover:border-primary/40' }}">
                <input type="radio" name="login_2fa_method" value="sms" {{ $method === 'sms' ? 'checked' : '' }}
                       class="mt-1 accent-primary">
                <span>
                    <span class="block text-sm font-semibold text-black">SMS verification</span>
                    <span class="block text-xs text-muted mt-0.5">A 6-digit code is sent to the user's phone number. Customers without a phone on file fall back to email; the admin login uses email for this option.</span>
                    @if (! $smsActive)
                        <span class="inline-flex items-center gap-1.5 mt-2 rounded-[12px] bg-amber-100 text-amber-800 text-xs font-semibold px-3 py-1">
                            <i class="fas fa-triangle-exclamation text-[10px]"></i>
                            SMS gateway is currently disabled - configure it under SMS Settings first.
                        </span>
                    @endif
                </span>
            </label>
        </div>

        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm mb-6 space-y-4">
            <h2 class="text-lg font-semibold text-black">New Account Verification</h2>
            <p class="text-sm text-muted -mt-2">Controls whether a code is required when a customer creates an account.</p>

            {{-- No verification --}}
            <label class="flex items-start gap-3 rounded-[12px] border p-4 cursor-pointer transition
                {{ $signup === 'none' ? 'border-primary bg-primary/5' : 'border-border bg-white hover:border-primary/40' }}">
                <input type="radio" name="signup_verification" value="none" {{ $signup === 'none' ? 'checked' : '' }}
                       class="mt-1 accent-primary">
                <span>
                    <span class="block text-sm font-semibold text-black">No verification (default)</span>
                    <span class="block text-xs text-muted mt-0.5">Accounts are created instantly with no OTP or email step.</span>
                </span>
            </label>

            {{-- Email --}}
            <label class="flex items-start gap-3 rounded-[12px] border p-4 cursor-pointer transition
                {{ $signup === 'email' ? 'border-primary bg-primary/5' : 'border-border bg-white hover:border-primary/40' }}">
                <input type="radio" name="signup_verification" value="email" {{ $signup === 'email' ? 'checked' : '' }}
                       class="mt-1 accent-primary">
                <span>
                    <span class="block text-sm font-semibold text-black">Email verification</span>
                    <span class="block text-xs text-muted mt-0.5">A 6-digit code is emailed before the account is created. Requires email settings to be configured.</span>
                </span>
            </label>

            {{-- SMS --}}
            <label class="flex items-start gap-3 rounded-[12px] border p-4 cursor-pointer transition
                {{ $signup === 'sms' ? 'border-primary bg-primary/5' : 'border-border bg-white hover:border-primary/40' }}">
                <input type="radio" name="signup_verification" value="sms" {{ $signup === 'sms' ? 'checked' : '' }}
                       class="mt-1 accent-primary">
                <span>
                    <span class="block text-sm font-semibold text-black">SMS verification</span>
                    <span class="block text-xs text-muted mt-0.5">A 6-digit code is sent to the phone number, falling back to email if the gateway is unavailable.</span>
                    @if (! $smsActive)
                        <span class="inline-flex items-center gap-1.5 mt-2 rounded-[12px] bg-amber-100 text-amber-800 text-xs font-semibold px-3 py-1">
                            <i class="fas fa-triangle-exclamation text-[10px]"></i>
                            SMS gateway is currently disabled - configure it under SMS Settings first.
                        </span>
                    @endif
                </span>
            </label>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="rounded-[8px] bg-primary px-6 py-2.5 text-sm font-semibold text-white hover:opacity-90">
                Save Settings
            </button>
        </div>
    </form>

@endsection
