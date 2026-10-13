{{-- ---------------
-- Client Loyalty Redeem Page
-- --------------- --}}
@extends('client.layouts.app')

@section('title', 'Redeem Points | Haromi')

@section('content')

    {{-- ---------------
    -- Page Header
    -- --------------- --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Redeem Points</h2>
            <p class="text-sm text-gray-500 mt-0.5">Apply your loyalty points as a discount at checkout.</p>
        </div>
        <a href="{{ route('client.loyalty.index') }}"
           class="inline-flex items-center gap-1 text-sm text-muted hover:text-primary transition">
            <i class="fas fa-arrow-left text-xs"></i> Back
        </a>
    </div>

    {{-- ---------------
    -- Flash
    -- --------------- --}}
    @if (session('info'))
        <div class="mb-5 flex items-center gap-3 bg-blue-50 border border-blue-200 text-blue-800 text-sm rounded-[8px] px-4 py-3">
            <i class="fas fa-info-circle text-blue-500"></i> {{ session('info') }}
        </div>
    @endif

    @if (!$settings->loyalty_enabled)

        <div class="rounded-[12px] border border-amber-200 bg-amber-50 px-5 py-8 text-center">
            <i class="fas fa-pause-circle text-3xl text-amber-300 mb-3"></i>
            <p class="text-sm font-medium text-amber-800">The loyalty programme is currently paused.</p>
        </div>

    @else

        {{-- ---------------
        -- Balance Summary Card
        -- --------------- --}}
        <div class="rounded-[12px] border border-gray-200 bg-white p-5 mb-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Available Balance</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">
                        {{ number_format($record?->points_balance ?? 0) }}
                        <span class="text-sm font-normal text-gray-500">points</span>
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500">Equivalent value</p>
                    <p class="text-xl font-semibold text-emerald-600">
                        KES {{ number_format(($record?->points_balance ?? 0) / max(1, $settings->redemption_rate), 2) }}
                    </p>
                </div>
            </div>
        </div>

        @if (($record?->points_balance ?? 0) < $settings->min_redeem_points)

            {{-- ---------------
            -- Insufficient Balance
            -- --------------- --}}
            <div class="rounded-[12px] border border-gray-200 bg-gray-50 px-5 py-8 text-center">
                <i class="fas fa-lock text-3xl text-gray-300 mb-3"></i>
                <p class="text-sm font-semibold text-gray-700 mb-1">Not enough points to redeem</p>
                <p class="text-xs text-gray-500">
                    You need at least <strong>{{ number_format($settings->min_redeem_points) }} points</strong> to redeem.
                    You currently have <strong>{{ number_format($record?->points_balance ?? 0) }}</strong>.
                </p>
                <a href="{{ route('client.loyalty.index') }}"
                   class="mt-4 inline-block px-5 py-2 bg-primary text-white text-sm font-semibold rounded-[12px] hover:opacity-90 transition">
                    Keep Earning
                </a>
            </div>

        @else

            {{-- ---------------
            -- Redemption Instructions
            -- --------------- --}}
            <div class="rounded-[12px] border border-emerald-200 bg-emerald-50 px-5 py-4 mb-5">
                <p class="text-sm font-semibold text-emerald-800 mb-2">
                    <i class="fas fa-info-circle mr-1"></i> How redemption works
                </p>
                <ul class="text-xs text-emerald-700 space-y-1 list-disc list-inside">
                    <li>Points are applied as a discount when you place your next order.</li>
                    <li>{{ number_format($settings->redemption_rate) }} points = KES 1 off your order total.</li>
                    <li>You choose how many points to apply at the checkout screen.</li>
                    <li>Unused points remain in your balance for future orders.</li>
                </ul>
            </div>

            <div class="rounded-[12px] border border-gray-200 bg-white p-5 text-center">
                <i class="fas fa-shopping-cart text-3xl text-primary mb-3"></i>
                <p class="text-sm font-semibold text-gray-800 mb-1">Ready to redeem?</p>
                <p class="text-xs text-gray-500 mb-4">
                    Head to checkout and you will see an option to apply your loyalty points.
                </p>
                <a href="{{ route('client.orders.index') }}"
                   class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary text-white text-sm font-semibold rounded-[12px] hover:opacity-90 transition">
                    <i class="fas fa-box text-xs"></i> Go to My Orders
                </a>
            </div>

        @endif

        {{-- ---------------
        -- Tier Multiplier Reference
        -- --------------- --}}
        <div class="mt-5 rounded-[12px] border border-gray-200 bg-white p-5">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Earn Rate by Tier</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs text-center">
                @php
                    $refTierColors = [
                        'Bronze'   => 'border-amber-200 bg-amber-50 text-amber-800',
                        'Silver'   => 'border-gray-200 bg-gray-50 text-gray-700',
                        'Gold'     => 'border-yellow-200 bg-yellow-50 text-yellow-800',
                        'Platinum' => 'border-blue-200 bg-blue-50 text-blue-800',
                    ];
                    $allTiers = \App\Models\Manage\Loyalty\LoyaltyTier::where('is_active', 1)->orderBy('min_points')->get();
                @endphp
                @foreach ($allTiers as $t)
                    <div class="rounded-[8px] border p-3 {{ $refTierColors[$t->name] ?? 'border-gray-200 bg-gray-50 text-gray-700' }}">
                        <p class="font-semibold">{{ $t->name }}</p>
                        <p class="mt-1">{{ $t->points_multiplier }}× multiplier</p>
                        <p class="text-[11px] opacity-70">{{ $t->discount_percent }}% auto discount</p>
                    </div>
                @endforeach
            </div>
        </div>

    @endif

@endsection
