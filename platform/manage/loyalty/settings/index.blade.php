@extends('manage.layouts.app')

@section('title', 'Loyalty Programme Settings')
@section('meta-description', 'Configure loyalty point earn rates, redemption rules, and programme toggle.')

@section('content')

    {{-- ---------------
    -- Breadcrumb
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.loyalty.settings.index') }}" class="hover:text-primary">Loyalty Points</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Settings</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Loyalty Programme Settings</h1>
                <p class="text-sm text-muted">
                    Configure how points are earned per purchase and how they are redeemed at checkout.
                </p>
            </div>
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

    {{-- ---------------
    -- Settings Form
    -- --------------- --}}
    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm mb-6">
        <h2 class="text-base font-semibold text-black mb-1">Programme Configuration</h2>
        <p class="text-xs text-muted mb-5">
            Changes take effect immediately for all future orders.
        </p>

        <form method="POST" action="{{ route('manage.loyalty.settings.update') }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">

                {{-- Toggle --}}
                <div class="sm:col-span-2">
                    <label class="flex items-center gap-3 cursor-pointer select-none">
                        <input type="hidden" name="loyalty_enabled" value="0">
                        <input type="checkbox" name="loyalty_enabled" value="1"
                               class="h-4 w-4 rounded border-border text-primary focus:ring-primary"
                               {{ $settings->loyalty_enabled ? 'checked' : '' }}>
                        <span class="text-sm font-medium text-black">Enable Loyalty Programme</span>
                    </label>
                    <p class="mt-1 ml-7 text-xs text-muted">When disabled, no points are earned or redeemed platform-wide.</p>
                </div>

                {{-- KES per point --}}
                <div>
                    <label for="kes_per_point" class="block text-sm font-medium text-black mb-1">
                        KES per Point <span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="0.01" min="1" id="kes_per_point" name="kes_per_point"
                           value="{{ old('kes_per_point', $settings->kes_per_point) }}"
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none"
                           required>
                    <p class="mt-1 text-xs text-muted">
                        Every this many KES spent earns 1 base point. E.g. <strong>10</strong> = KES 10 spent = 1 point.
                    </p>
                </div>

                {{-- Redemption rate --}}
                <div>
                    <label for="redemption_rate" class="block text-sm font-medium text-black mb-1">
                        Points per KES 1 Discount <span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="0.01" min="1" id="redemption_rate" name="redemption_rate"
                           value="{{ old('redemption_rate', $settings->redemption_rate) }}"
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none"
                           required>
                    <p class="mt-1 text-xs text-muted">
                        How many points equal KES 1 off at checkout. E.g. <strong>10</strong> = 10 points = KES 1 discount.
                    </p>
                </div>

                {{-- Minimum redemption --}}
                <div>
                    <label for="min_redeem_points" class="block text-sm font-medium text-black mb-1">
                        Minimum Redeemable Points <span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="1" min="1" id="min_redeem_points" name="min_redeem_points"
                           value="{{ old('min_redeem_points', $settings->min_redeem_points) }}"
                           class="w-full rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-black focus:border-primary focus:outline-none"
                           required>
                    <p class="mt-1 text-xs text-muted">
                        Clients must hold at least this many points before they can redeem any.
                    </p>
                </div>

            </div>

            {{-- ---------------
            -- Summary Preview
            -- --------------- --}}
            <div class="mb-6 rounded-[12px] border border-border bg-slate-50 px-5 py-4 text-sm text-gray-700">
                <p class="font-medium text-black mb-2">How the current settings work:</p>
                <ul class="list-disc list-inside space-y-1 text-xs text-muted">
                    <li>A client who spends <strong>KES 1,000</strong> earns
                        <strong>{{ $settings->kes_per_point > 0 ? floor(1000 / $settings->kes_per_point) : '–' }} base points</strong>
                        (before tier multiplier).
                    </li>
                    <li>A Gold tier client (1.5× multiplier) on that same order earns
                        <strong>{{ $settings->kes_per_point > 0 ? floor(floor(1000 / $settings->kes_per_point) * 1.5) : '–' }} points</strong>.
                    </li>
                    <li><strong>{{ $settings->min_redeem_points }}</strong> points minimum required to redeem at checkout.</li>
                    <li><strong>{{ $settings->redemption_rate }}</strong> points = KES 1 discount.</li>
                </ul>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('manage.loyalty.settings.index') }}"
                   class="rounded-[8px] border border-border px-5 py-2 text-sm font-medium text-black hover:bg-slate-50">
                    Cancel
                </a>
                <button type="submit"
                        class="rounded-[8px] bg-primary px-5 py-2 text-sm font-medium text-white hover:bg-primary/90">
                    Save Settings
                </button>
            </div>
        </form>
    </div>

@endsection
