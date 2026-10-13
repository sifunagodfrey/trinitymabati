{{-- -------------------
     Admin Referrals - Codes Overview
------------------- --}}
@extends('manage.layouts.app')

@section('title', 'Referral Codes - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Referral Codes</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Referral Codes</h1>
                <p class="text-sm text-muted">Track customer referral links and their performance.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('manage.ecommerce.referrals.events') }}"
                    class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-2.5 text-sm font-medium text-muted transition hover:bg-slate-100">
                    <i class="fa-solid fa-user-plus"></i>
                    Signups
                </a>
                <a href="{{ route('manage.ecommerce.referrals.settings') }}"
                    class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
                    <i class="fa-solid fa-gear"></i>
                    Program Settings
                </a>
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
    @if (session('error'))
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            {{ session('error') }}
        </div>
    @endif

    {{-- ---------------
    -- Search
    -- --------------- --}}
    <form method="GET" class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center">
        <div class="relative flex-1">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-xs text-muted"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search by code or customer..."
                class="w-full rounded-[12px] border border-border bg-white py-2.5 pl-10 pr-4 text-sm text-black outline-none focus:border-primary" />
        </div>
        <button type="submit"
            class="inline-flex items-center justify-center gap-2 rounded-[12px] border border-border bg-background px-5 py-2.5 text-sm font-medium text-muted transition hover:bg-slate-100">
            Search
        </button>
    </form>

    {{-- ---------------
    -- Referral Codes Table
    -- --------------- --}}
    <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-[840px] divide-y divide-border text-sm">
                <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                    <tr>
                        <th class="px-4 py-3">Code</th>
                        <th class="px-4 py-3">Customer</th>
                        <th class="px-4 py-3 text-center">Clicks</th>
                        <th class="px-4 py-3 text-center">Signups</th>
                        <th class="px-4 py-3 text-center">Rewarded</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-white">
                    @forelse ($codes as $code)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4">
                                <span class="font-mono text-sm font-semibold text-black">{{ $code->code }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <p class="text-sm font-medium text-black">{{ $code->user?->name ?? 'Unknown' }}</p>
                                <p class="text-xs text-muted">{{ $code->user?->email }}</p>
                            </td>
                            <td class="px-4 py-4 text-center text-sm text-muted">{{ number_format($code->clicks) }}</td>
                            <td class="px-4 py-4 text-center text-sm text-muted">{{ number_format($code->events_count) }}</td>
                            <td class="px-4 py-4 text-center text-sm text-muted">{{ number_format($code->rewarded_events_count) }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold
                                    {{ $code->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $code->is_active ? 'Active' : 'Paused' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-right">
                                <form method="POST" action="{{ route('manage.ecommerce.referrals.toggle', $code->id) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                        title="{{ $code->is_active ? 'Pause' : 'Activate' }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border transition
                                            {{ $code->is_active
                                                ? 'border-slate-200 bg-slate-50 text-slate-600 hover:bg-slate-100'
                                                : 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                                        <i class="fa-solid {{ $code->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }} text-xs"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-sm text-muted">
                                <div class="flex flex-col items-center gap-3">
                                    <i class="fa-solid fa-share-nodes text-3xl text-slate-300"></i>
                                    <span>No referral codes yet. Codes are created when customers open their referral page.</span>
                                </div>
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
    <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-muted">
            Showing {{ $codes->firstItem() ?? 0 }} – {{ $codes->lastItem() ?? 0 }}
            of {{ $codes->total() }} codes
        </p>
        <div>{{ $codes->links() }}</div>
    </div>

@endsection
