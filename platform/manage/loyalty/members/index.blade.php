@extends('manage.layouts.app')

@section('title', 'Loyalty Members')

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
                <li class="text-black font-semibold">Members</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Loyalty Members</h1>
                <p class="text-sm text-muted">
                    {{ $members->total() }} {{ Str::plural('member', $members->total()) }} enrolled in the loyalty programme.
                </p>
            </div>
            <a href="{{ route('manage.loyalty.adjust.create') }}"
               class="inline-flex items-center gap-2 rounded-[8px] bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary/90">
                <i class="fas fa-sliders-h text-xs"></i> Adjust Points
            </a>
        </div>
    </div>

    {{-- ---------------
    -- Members Table
    -- --------------- --}}
    <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-[720px] divide-y divide-border text-sm">
                <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                    <tr>
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3">Tier</th>
                        <th class="px-4 py-3">Points Balance</th>
                        <th class="px-4 py-3">Lifetime Points</th>
                        <th class="px-4 py-3">Last Updated</th>
                        <th class="px-4 py-3 text-right">Actions</th>
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
                    @forelse ($members as $member)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4">
                                <div class="font-medium text-black">{{ $member->user_name }}</div>
                                <div class="text-xs text-muted">{{ $member->email }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center gap-1 rounded-[12px] px-2.5 py-1 text-xs font-semibold
                                    {{ $tierColors[$member->tier_name] ?? 'bg-slate-100 text-slate-700' }}">
                                    <i class="fas fa-star text-[9px]"></i>
                                    {{ $member->tier_name }}
                                </span>
                            </td>
                            <td class="px-4 py-4 font-semibold text-black">
                                {{ number_format($member->points_balance) }}
                            </td>
                            <td class="px-4 py-4 text-gray-600">
                                {{ number_format($member->lifetime_points) }}
                            </td>
                            <td class="px-4 py-4 text-muted text-xs">
                                {{ \Carbon\Carbon::parse($member->updated_at)->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-4 text-right">
                                <a href="{{ route('manage.loyalty.adjust.create') }}?user_id={{ $member->user_id }}"
                                   class="inline-flex items-center gap-1 rounded-[8px] border border-border px-3 py-1.5 text-xs font-medium text-black hover:bg-slate-50 transition">
                                    <i class="fas fa-sliders-h text-[10px]"></i> Adjust
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-sm text-muted">
                                No members enrolled yet.
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
    @if ($members->hasPages())
        <div class="mt-6">{{ $members->links() }}</div>
    @endif

@endsection
