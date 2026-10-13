{{-- ---------------
-- Client Loyalty Transaction History
-- --------------- --}}
@extends('client.layouts.app')

@section('title', 'Points History | Haromi')

@section('content')

    @php
        $typeConfig = [
            'earn'   => ['bg-emerald-100 text-emerald-700', 'fa-arrow-up',   'Earned'],
            'redeem' => ['bg-blue-100 text-blue-700',       'fa-arrow-down', 'Redeemed'],
            'expire' => ['bg-orange-100 text-orange-700',   'fa-clock',      'Expired'],
            'adjust' => ['bg-purple-100 text-purple-700',   'fa-sliders-h',  'Adjusted'],
        ];
    @endphp

    {{-- ---------------
    -- Page Header
    -- --------------- --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Points History</h2>
            <p class="text-sm text-gray-500 mt-0.5">
                {{ $transactions->total() }} {{ Str::plural('transaction', $transactions->total()) }}
            </p>
        </div>
        <a href="{{ route('client.loyalty.index') }}"
           class="inline-flex items-center gap-1 text-sm text-muted hover:text-primary transition">
            <i class="fas fa-arrow-left text-xs"></i> Back
        </a>
    </div>

    @if ($transactions->isNotEmpty())

        <div class="bg-white rounded-[12px] border border-gray-200 overflow-hidden">
            <div class="divide-y divide-gray-100">
                @foreach ($transactions as $tx)
                    @php
                        [$typeCls, $typeIcon, $typeLabel] = $typeConfig[$tx->type] ?? ['bg-gray-100 text-gray-600', 'fa-circle', ucfirst($tx->type)];
                        $isPositive = $tx->points > 0;
                    @endphp
                    <div class="flex items-center gap-3 px-4 py-4">
                        <div class="w-9 h-9 rounded-[12px] {{ $typeCls }} flex items-center justify-center flex-shrink-0">
                            <i class="fas {{ $typeIcon }} text-xs"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">
                                {{ $typeLabel }}
                                @if ($tx->order_id)
                                    <span class="text-xs text-gray-400 font-normal ml-1">Order #{{ $tx->order_id }}</span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $tx->description ?? '-' }}</p>
                            <p class="text-xs text-gray-400">
                                {{ \Carbon\Carbon::parse($tx->created_at)->format('M d, Y \a\t H:i') }}
                            </p>
                        </div>
                        <span class="text-base font-bold {{ $isPositive ? 'text-emerald-600' : 'text-red-500' }} flex-shrink-0">
                            {{ $isPositive ? '+' : '' }}{{ number_format($tx->points) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ---------------
        -- Pagination
        -- --------------- --}}
        @if ($transactions->hasPages())
            <div class="mt-6">{{ $transactions->links() }}</div>
        @endif

    @else

        <div class="text-center py-20">
            <div class="w-16 h-16 rounded-[12px] bg-gray-100 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-history text-2xl text-gray-300"></i>
            </div>
            <h3 class="text-base font-bold text-gray-900 mb-1">No transactions yet</h3>
            <p class="text-sm text-gray-500">Your point earn and redeem history will appear here.</p>
        </div>

    @endif

@endsection
