@extends('manage.layouts.app')

@section('title', 'Loyalty Tiers')

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
                <li class="text-black font-semibold">Tiers</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Loyalty Tiers</h1>
                <p class="text-sm text-muted">Manage tier thresholds, discounts, and earn multipliers.</p>
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

    {{-- ---------------
    -- Tiers Table
    -- --------------- --}}
    <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-[720px] divide-y divide-border text-sm">
                <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                    <tr>
                        <th class="px-4 py-3">Tier</th>
                        <th class="px-4 py-3">Min Lifetime Points</th>
                        <th class="px-4 py-3">Earn Multiplier</th>
                        <th class="px-4 py-3">Auto Discount</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-white">
                    @php
                        $tierColors = [
                            'Bronze'   => 'bg-amber-100 text-amber-800',
                            'Silver'   => 'bg-gray-100 text-gray-700',
                            'Gold'     => 'bg-yellow-100 text-yellow-800',
                            'Platinum' => 'bg-blue-100 text-blue-800',
                        ];
                    @endphp
                    @forelse ($tiers as $tier)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center gap-1.5 rounded-[12px] px-3 py-1 text-xs font-semibold
                                    {{ $tierColors[$tier->name] ?? 'bg-slate-100 text-slate-700' }}">
                                    <i class="fas fa-star text-[10px]"></i>
                                    {{ $tier->name }}
                                </span>
                            </td>
                            <td class="px-4 py-4 font-medium text-black">
                                {{ number_format($tier->min_points) }} pts
                            </td>
                            <td class="px-4 py-4 text-black">{{ $tier->points_multiplier }}×</td>
                            <td class="px-4 py-4 text-black">{{ $tier->discount_percent }}%</td>
                            <td class="px-4 py-4">
                                @if ($tier->is_active)
                                    <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold bg-emerald-100 text-emerald-800">Active</span>
                                @else
                                    <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold bg-slate-100 text-slate-600">Inactive</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-right">
                                <a href="{{ route('manage.loyalty.tiers.edit', $tier->id) }}"
                                   class="inline-flex items-center gap-1 rounded-[8px] border border-border px-4 py-2 text-xs font-medium text-black hover:bg-slate-50 transition">
                                    <i class="fas fa-pen text-[10px]"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-sm text-muted">No tiers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
