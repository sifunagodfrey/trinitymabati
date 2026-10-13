@extends('manage.layouts.app')

@section('title', 'Loyalty Transactions')

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
                <li class="text-black font-semibold">Transactions</li>
            </ol>
        </nav>

        <div>
            <h1 class="text-2xl font-semibold text-black">Loyalty Transactions</h1>
            <p class="text-sm text-muted">Full audit log of every point earn, redeem, expiry, and manual adjustment.</p>
        </div>
    </div>

    {{-- ---------------
    -- Transactions Table
    -- --------------- --}}
    <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-[840px] divide-y divide-border text-sm">
                <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Points</th>
                        <th class="px-4 py-3">Order</th>
                        <th class="px-4 py-3">Description</th>
                        <th class="px-4 py-3">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-white">
                    @php
                        $typeConfig = [
                            'earn'   => ['bg-emerald-100 text-emerald-800', 'Earn'],
                            'redeem' => ['bg-blue-100 text-blue-800',       'Redeem'],
                            'expire' => ['bg-orange-100 text-orange-800',   'Expire'],
                            'adjust' => ['bg-purple-100 text-purple-800',   'Adjust'],
                        ];
                    @endphp
                    @forelse ($transactions as $tx)
                        @php
                            [$typeCls, $typeLabel] = $typeConfig[$tx->type] ?? ['bg-slate-100 text-slate-700', ucfirst($tx->type)];
                            $isPositive = $tx->points > 0;
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4 text-muted text-xs">{{ $tx->id }}</td>
                            <td class="px-4 py-4">
                                <div class="font-medium text-black">{{ $tx->user_name }}</div>
                                <div class="text-xs text-muted">{{ $tx->email }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-[12px] px-2.5 py-1 text-xs font-semibold {{ $typeCls }}">
                                    {{ $typeLabel }}
                                </span>
                            </td>
                            <td class="px-4 py-4 font-semibold {{ $isPositive ? 'text-emerald-700' : 'text-red-600' }}">
                                {{ $isPositive ? '+' : '' }}{{ number_format($tx->points) }}
                            </td>
                            <td class="px-4 py-4 text-muted text-xs">
                                {{ $tx->order_id ? '#' . $tx->order_id : '-' }}
                            </td>
                            <td class="px-4 py-4 text-gray-600 max-w-xs truncate">
                                {{ $tx->description ?? '-' }}
                            </td>
                            <td class="px-4 py-4 text-muted text-xs whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($tx->created_at)->format('M d, Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-sm text-muted">
                                No loyalty transactions recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ---------------
    -- Pagination
    -- --------------- --}}
    @if ($transactions->hasPages())
        <div class="mt-6">{{ $transactions->links() }}</div>
    @endif

@endsection
