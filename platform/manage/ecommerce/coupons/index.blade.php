{{-- -------------------
     Admin Coupons - List
------------------- --}}
@extends('manage.layouts.app')

@section('title', 'Coupon Codes - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Coupon Codes</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Coupon Codes</h1>
                <p class="text-sm text-muted">Manage coupon codes and promotional campaigns.</p>
            </div>
            <a href="{{ route('manage.ecommerce.coupons.create') }}"
                class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-plus"></i>
                Add Coupon Code
            </a>
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

    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">

        {{-- ---------------
        -- Search + Status Filter
        -- --------------- --}}
        <form method="GET" action="{{ route('manage.ecommerce.coupons.index') }}"
              class="mb-6 flex flex-wrap items-center gap-3">

            <div class="flex-1 min-w-[220px] flex items-center bg-white border border-border rounded-[12px] overflow-hidden">
                <i class="fa-solid fa-magnifying-glass text-muted pl-4 pr-2 text-sm flex-shrink-0"></i>
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Search by code..."
                    class="flex-1 px-2 py-3 text-sm text-black outline-none bg-transparent border-0" />
                @if (request('search'))
                    <a href="{{ route('manage.ecommerce.coupons.index', request()->except(['search', 'page'])) }}"
                        class="pr-3 text-muted hover:text-red-400 transition text-xs">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>

            <select name="status" onchange="this.form.submit()"
                class="rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>

            <button type="submit"
                class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-3 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-magnifying-glass"></i>
                Search
            </button>

            @if (request()->hasAny(['search', 'status']))
                <a href="{{ route('manage.ecommerce.coupons.index') }}"
                    class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-3 text-sm text-muted transition hover:bg-slate-100">
                    <i class="fa-solid fa-xmark"></i>
                    Clear
                </a>
            @endif

        </form>

        {{-- ---------------
        -- Discounts Table
        -- --------------- --}}
        <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[840px] divide-y divide-border text-sm">
                    <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                        <tr>
                            <th class="px-4 py-3">Code</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3 text-right">Value</th>
                            <th class="px-4 py-3 text-center">Usage</th>
                            <th class="px-4 py-3">Validity</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border bg-white">
                        @forelse ($coupons as $coupon)
                            @php
                                $statusColors = [
                                    'active'   => 'bg-emerald-100 text-emerald-800',
                                    'inactive' => 'bg-slate-100 text-slate-600',
                                ];
                            @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-4">
                                    <span class="font-mono text-sm font-semibold text-black">{{ $coupon->code }}</span>
                                </td>
                                <td class="px-4 py-4 text-sm text-black capitalize">
                                    {{ $coupon->discount_type === 'percent' ? 'Percentage' : 'Fixed Amount' }}
                                </td>
                                <td class="px-4 py-4 text-right font-semibold text-black">
                                    @if ($coupon->discount_type === 'percent')
                                        {{ number_format($coupon->value, 0) }}%
                                    @else
                                        KES {{ number_format($coupon->value, 2) }}
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center text-sm text-muted">
                                    {{ number_format($coupon->used_count) }}
                                    @if ($coupon->usage_limit)
                                        / {{ number_format($coupon->usage_limit) }}
                                    @else
                                        / ∞
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-xs text-muted">
                                    @if ($coupon->start_date || $coupon->end_date)
                                        {{ $coupon->start_date ? \Carbon\Carbon::parse($coupon->start_date)->format('d M Y') : '-' }}
                                        →
                                        {{ $coupon->end_date ? \Carbon\Carbon::parse($coupon->end_date)->format('d M Y') : '∞' }}
                                    @else
                                        <span class="text-muted">No limit</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold
                                        {{ $statusColors[$coupon->status] ?? 'bg-slate-100 text-slate-600' }}">
                                        {{ ucfirst($coupon->status ?? 'inactive') }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <div class="inline-flex items-center gap-1">
                                        {{-- Edit --}}
                                        <a href="{{ route('manage.ecommerce.coupons.edit', $coupon->id) }}" title="Edit"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-border bg-background text-muted transition hover:bg-slate-100 hover:text-black">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>

                                        {{-- Toggle Status --}}
                                        <form method="POST" action="{{ route('manage.ecommerce.coupons.toggle', $coupon->id) }}">
                                            @csrf
                                            <button type="submit"
                                                title="{{ $coupon->status === 'active' ? 'Deactivate' : 'Activate' }}"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border transition
                                                    {{ $coupon->status === 'active'
                                                        ? 'border-slate-200 bg-slate-50 text-slate-600 hover:bg-slate-100'
                                                        : 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                                                <i class="fa-solid {{ $coupon->status === 'active' ? 'fa-toggle-on' : 'fa-toggle-off' }} text-xs"></i>
                                            </button>
                                        </form>

                                        {{-- Delete --}}
                                        <form method="POST" action="{{ route('manage.ecommerce.coupons.destroy', $coupon->id) }}"
                                              onsubmit="return confirm('Delete this coupon code permanently?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-rose-200 bg-rose-50 text-rose-600 transition hover:bg-rose-100">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center text-sm text-muted">
                                    <div class="flex flex-col items-center gap-3">
                                        <i class="fa-solid fa-tag text-3xl text-slate-300"></i>
                                        <span>No coupon codes found.</span>
                                        @if (request()->hasAny(['search', 'status']))
                                            <a href="{{ route('manage.ecommerce.coupons.index') }}"
                                                class="text-xs text-primary hover:underline">Clear filters</a>
                                        @endif
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
                Showing {{ $coupons->firstItem() ?? 0 }} – {{ $coupons->lastItem() ?? 0 }}
                of {{ $coupons->total() }} codes
            </p>
            <div>{{ $coupons->links() }}</div>
        </div>

    </div>

@endsection
