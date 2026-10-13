{{-- -------------------
     Admin Referrals - Program Settings
------------------- --}}
@extends('manage.layouts.app')

@section('title', 'Referral Settings - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.ecommerce.referrals.index') }}" class="hover:text-primary">Referral Codes</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Settings</li>
            </ol>
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ route('manage.ecommerce.referrals.index') }}"
                class="inline-flex items-center gap-1.5 text-sm font-medium text-muted hover:text-black transition">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Back
            </a>
            <div>
                <h1 class="text-2xl font-semibold text-black">Referral Program Settings</h1>
                <p class="text-sm text-muted">Configure how referral rewards are issued.</p>
            </div>
        </div>
    </div>

    {{-- ---------------
    -- Session Alerts
    -- --------------- --}}
    @if (session('success'))
        <div class="mb-6 rounded-[12px] border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('manage.ecommerce.referrals.settings.update') }}"
          class="bg-background border border-border rounded-[12px] p-6 shadow-sm space-y-6">
        @csrf

        <div class="grid gap-5 sm:grid-cols-2">

            {{-- Program Status --}}
            <div class="flex flex-col gap-1 sm:col-span-2">
                <label class="text-xs font-semibold text-muted uppercase tracking-wide">Program Status</label>
                <select name="referral_enabled"
                    class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary">
                    <option value="1" {{ old('referral_enabled', $settings['referral_enabled'] ? '1' : '0') === '1' ? 'selected' : '' }}>Enabled</option>
                    <option value="0" {{ old('referral_enabled', $settings['referral_enabled'] ? '1' : '0') === '0' ? 'selected' : '' }}>Paused</option>
                </select>
                <p class="text-xs text-muted">When paused, referral links stop tracking clicks and signups.</p>
            </div>

            {{-- Reward Type --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold text-muted uppercase tracking-wide">
                    Reward Type <span class="text-rose-500">*</span>
                </label>
                <select name="referral_reward_type" required
                    class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary">
                    <option value="wallet" {{ old('referral_reward_type', $settings['referral_reward_type']) === 'wallet' ? 'selected' : '' }}>Wallet Credit (KES)</option>
                    <option value="loyalty_points" {{ old('referral_reward_type', $settings['referral_reward_type']) === 'loyalty_points' ? 'selected' : '' }}>Loyalty Points</option>
                </select>
            </div>

            {{-- Referrer Reward --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold text-muted uppercase tracking-wide">
                    Referrer Reward <span class="text-rose-500">*</span>
                </label>
                <input type="number" name="referral_reward_value" required min="0" step="0.01"
                    value="{{ old('referral_reward_value', $settings['referral_reward_value']) }}"
                    class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary" />
                <p class="text-xs text-muted">Amount issued to the referrer when a reward is approved.</p>
            </div>

            {{-- Referred Reward --}}
            <div class="flex flex-col gap-1 sm:col-span-2">
                <label class="text-xs font-semibold text-muted uppercase tracking-wide">
                    New Customer Reward <span class="text-rose-500">*</span>
                </label>
                <input type="number" name="referral_referred_reward_value" required min="0" step="0.01"
                    value="{{ old('referral_referred_reward_value', $settings['referral_referred_reward_value']) }}"
                    class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary" />
                <p class="text-xs text-muted">Optional welcome reward for the referred customer. Set 0 to disable.</p>
            </div>

        </div>

        {{-- ---------------
        -- Form Actions
        -- --------------- --}}
        <div class="flex items-center justify-end gap-3 pt-2 border-t border-border">
            <a href="{{ route('manage.ecommerce.referrals.index') }}"
                class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-5 py-2.5 text-sm font-medium text-muted transition hover:bg-slate-100">
                Cancel
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-5 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-floppy-disk"></i>
                Save Settings
            </button>
        </div>

    </form>

@endsection
