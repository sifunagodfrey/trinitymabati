{{-- ---------------
-- Client Loyalty Overview
-- --------------- --}}
@extends('client.layouts.app')

@section('title', 'My Loyalty Points | Haromi')

@section('content')

    @php
        $tierColors = [
            'Bronze'   => ['border-amber-300 bg-amber-50',   'text-amber-700',  'bg-amber-400'],
            'Silver'   => ['border-gray-300 bg-gray-50',     'text-gray-600',   'bg-gray-400'],
            'Gold'     => ['border-yellow-300 bg-yellow-50', 'text-yellow-700', 'bg-yellow-400'],
            'Platinum' => ['border-blue-300 bg-blue-50',     'text-blue-700',   'bg-blue-500'],
        ];
        $tierName     = $record?->tier?->name ?? 'Bronze';
        [$cardClass, $tierTextClass, $progressClass] = $tierColors[$tierName] ?? $tierColors['Bronze'];
        $typeConfig = [
            'earn'   => ['text-emerald-600', 'fa-arrow-up'],
            'redeem' => ['text-blue-600',    'fa-arrow-down'],
            'expire' => ['text-orange-500',  'fa-clock'],
            'adjust' => ['text-purple-600',  'fa-sliders-h'],
        ];
    @endphp

    {{-- ---------------
    -- Page Header
    -- --------------- --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Loyalty Points</h2>
            <p class="text-sm text-gray-500 mt-0.5">Earn points on every purchase and redeem them for discounts.</p>
        </div>
        <a href="{{ route('client.loyalty.history') }}"
           class="text-sm text-primary font-medium hover:underline">
            Full History <i class="fas fa-arrow-right text-xs ml-1"></i>
        </a>
    </div>

    {{-- ---------------
    -- Flash Messages
    -- --------------- --}}
    @if (session('success'))
        <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-[8px] px-4 py-3">
            <i class="fas fa-check-circle text-green-500"></i> {{ session('success') }}
        </div>
    @endif
    @if (session('info'))
        <div class="mb-5 flex items-center gap-3 bg-blue-50 border border-blue-200 text-blue-800 text-sm rounded-[8px] px-4 py-3">
            <i class="fas fa-info-circle text-blue-500"></i> {{ session('info') }}
        </div>
    @endif

    @if (!$settings->loyalty_enabled)

        {{-- ---------------
        -- Programme Disabled Notice
        -- --------------- --}}
        <div class="rounded-[12px] border border-amber-200 bg-amber-50 px-5 py-8 text-center">
            <i class="fas fa-star text-3xl text-amber-300 mb-3"></i>
            <p class="text-sm font-medium text-amber-800">The loyalty programme is currently paused.</p>
            <p class="text-xs text-amber-600 mt-1">Points are not being earned or redeemed at this time.</p>
        </div>

    @else

        {{-- ---------------
        -- Tier & Balance Card
        -- --------------- --}}
        <div class="rounded-[12px] border-2 {{ $cardClass }} p-5 mb-5">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide {{ $tierTextClass }}">
                        <i class="fas fa-star mr-1"></i> {{ $tierName }} Member
                    </p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">
                        {{ number_format($record?->points_balance ?? 0) }}
                        <span class="text-sm font-normal text-gray-500">pts available</span>
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500">Lifetime earned</p>
                    <p class="text-lg font-semibold text-gray-700">
                        {{ number_format($record?->lifetime_points ?? 0) }} pts
                    </p>
                </div>
            </div>

            {{-- Progress to next tier --}}
            @if ($nextTier)
                <div>
                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                        <span>Progress to <strong>{{ $nextTier->name }}</strong></span>
                        <span>{{ number_format($record->lifetime_points) }} / {{ number_format($nextTier->min_points) }} pts</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-[12px] h-2">
                        <div class="{{ $progressClass }} h-2 rounded-[12px] transition-all"
                             style="width: {{ $progress }}%"></div>
                    </div>
                </div>
            @else
                <p class="text-xs {{ $tierTextClass }} font-medium mt-2">
                    <i class="fas fa-trophy mr-1"></i> You are at the highest tier!
                </p>
            @endif
        </div>

        {{-- ---------------
        -- How It Works
        -- --------------- --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-5">
            <div class="rounded-[8px] border border-gray-200 bg-white p-4 text-center">
                <i class="fas fa-shopping-bag text-primary text-xl mb-2"></i>
                <p class="text-xs font-semibold text-gray-700">Earn Points</p>
                <p class="text-xs text-gray-500 mt-0.5">
                    Every KES {{ number_format($settings->kes_per_point) }} spent = 1 point
                </p>
            </div>
            <div class="rounded-[8px] border border-gray-200 bg-white p-4 text-center">
                <i class="fas fa-tags text-emerald-500 text-xl mb-2"></i>
                <p class="text-xs font-semibold text-gray-700">Redeem at Checkout</p>
                <p class="text-xs text-gray-500 mt-0.5">
                    {{ number_format($settings->redemption_rate) }} points = KES 1 off
                </p>
            </div>
            <div class="rounded-[8px] border border-gray-200 bg-white p-4 text-center">
                <i class="fas fa-level-up-alt text-yellow-500 text-xl mb-2"></i>
                <p class="text-xs font-semibold text-gray-700">Tier Multipliers</p>
                <p class="text-xs text-gray-500 mt-0.5">Higher tiers earn more points per order</p>
            </div>
        </div>

        {{-- ---------------
        -- Redeem CTA (shown when balance meets minimum)
        -- --------------- --}}
        @if (($record?->points_balance ?? 0) >= $settings->min_redeem_points)
            <div class="rounded-[8px] border border-emerald-200 bg-emerald-50 px-4 py-3 flex items-center justify-between mb-5">
                <div>
                    <p class="text-sm font-semibold text-emerald-800">
                        You have {{ number_format($record->points_balance) }} redeemable points!
                    </p>
                    <p class="text-xs text-emerald-600 mt-0.5">
                        Worth up to KES {{ number_format($record->points_balance / $settings->redemption_rate, 2) }} off your next order.
                    </p>
                </div>
                <a href="{{ route('client.loyalty.redeem') }}"
                   class="ml-3 flex-shrink-0 inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 text-white text-xs font-semibold rounded-[12px] hover:bg-emerald-700 transition">
                    <i class="fas fa-gift text-xs"></i> Redeem
                </a>
            </div>
        @endif

        {{-- ---------------
        -- Recent Activity
        -- --------------- --}}
        @if ($recentTransactions->isNotEmpty())
            <div class="bg-white rounded-[12px] border border-gray-200 overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-900">Recent Activity</h3>
                    <a href="{{ route('client.loyalty.history') }}" class="text-xs text-primary hover:underline">View all</a>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach ($recentTransactions as $tx)
                        @php
                            [$txColor, $txIcon] = $typeConfig[$tx->type] ?? ['text-gray-600', 'fa-circle'];
                            $isPositive = $tx->points > 0;
                        @endphp
                        <div class="flex items-center gap-3 px-4 py-3">
                            <div class="w-8 h-8 rounded-[12px] bg-gray-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas {{ $txIcon }} text-xs {{ $txColor }}"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-800 truncate">
                                    {{ $tx->description ?? ucfirst($tx->type) }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    {{ \Carbon\Carbon::parse($tx->created_at)->format('M d, Y') }}
                                </p>
                            </div>
                            <span class="text-sm font-semibold {{ $isPositive ? 'text-emerald-600' : 'text-red-500' }} flex-shrink-0">
                                {{ $isPositive ? '+' : '' }}{{ number_format($tx->points) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-star text-3xl text-gray-200 mb-3"></i>
                <p class="text-sm text-gray-500">No activity yet. Start earning points by placing an order!</p>
            </div>
        @endif

    @endif

@endsection
