@extends('manage.layouts.app')

@section('title', 'Flash Sales - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Flash Sales</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Flash Sales</h1>
                <p class="text-sm text-muted">Time-limited discount campaigns on products.</p>
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

    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">

        {{-- ---------------
        -- Search + Status Filter
        -- --------------- --}}
        <form method="GET" action="{{ route('manage.ecommerce.flash-sales.index') }}"
              class="mb-6 flex flex-wrap items-center gap-3">

            <div class="flex-1 min-w-[220px] flex items-center bg-white border border-border rounded-[12px] overflow-hidden">
                <i class="fa-solid fa-magnifying-glass text-muted pl-4 pr-2 text-sm flex-shrink-0"></i>
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Search by product name..."
                    class="flex-1 px-2 py-3 text-sm text-black outline-none bg-transparent border-0" />
                @if (request('search'))
                    <a href="{{ route('manage.ecommerce.flash-sales.index', request()->except(['search', 'page'])) }}"
                        class="pr-3 text-muted hover:text-red-400 transition text-xs">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>

            <select name="status" onchange="this.form.submit()"
                class="rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
            </select>

            <button type="submit"
                class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-3 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-magnifying-glass"></i>
                Search
            </button>

            @if (request()->hasAny(['search', 'status']))
                <a href="{{ route('manage.ecommerce.flash-sales.index') }}"
                    class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-3 text-sm text-muted transition hover:bg-slate-100">
                    <i class="fa-solid fa-xmark"></i>
                    Clear
                </a>
            @endif

        </form>

        {{-- ---------------
        -- Flash Sales Table
        -- --------------- --}}
        <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[720px] divide-y divide-border text-sm">
                    <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                        <tr>
                            <th class="px-4 py-3">Product</th>
                            <th class="px-4 py-3 text-right">Original Price</th>
                            <th class="px-4 py-3 text-center">Discount</th>
                            <th class="px-4 py-3">Start</th>
                            <th class="px-4 py-3">End</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border bg-white">
                        @forelse ($flashSales as $sale)
                            @php
                                $statusColors = [
                                    'active'  => 'bg-emerald-100 text-emerald-800',
                                    'expired' => 'bg-slate-100 text-slate-600',
                                ];
                                $discountedPrice = ($sale->product->price ?? 0) * (1 - ($sale->discount_percentage / 100));
                            @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-4">
                                    <div class="font-medium text-black">{{ optional($sale->product)->name ?? '-' }}</div>
                                    <div class="text-xs text-muted">SKU: {{ optional($sale->product)->sku ?? '-' }}</div>
                                </td>
                                <td class="px-4 py-4 text-right text-sm text-black">
                                    KES {{ number_format($sale->product->price ?? 0, 2) }}
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex flex-col items-center">
                                        <span class="text-sm font-semibold text-rose-600">{{ $sale->discount_percentage }}% off</span>
                                        <span class="text-xs text-emerald-700">KES {{ number_format($discountedPrice, 2) }}</span>
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-xs text-muted whitespace-nowrap">
                                    {{ $sale->start_time ? \Carbon\Carbon::parse($sale->start_time)->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="px-4 py-4 text-xs text-muted whitespace-nowrap">
                                    {{ $sale->end_time ? \Carbon\Carbon::parse($sale->end_time)->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold
                                        {{ $statusColors[$sale->status] ?? 'bg-slate-100 text-slate-600' }}">
                                        {{ ucfirst($sale->status ?? '-') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center text-sm text-muted">
                                    <div class="flex flex-col items-center gap-3">
                                        <i class="fa-solid fa-bolt text-3xl text-slate-300"></i>
                                        <span>No flash sales found.</span>
                                        @if (request()->hasAny(['search', 'status']))
                                            <a href="{{ route('manage.ecommerce.flash-sales.index') }}"
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
                Showing {{ $flashSales->firstItem() ?? 0 }} – {{ $flashSales->lastItem() ?? 0 }}
                of {{ $flashSales->total() }} flash sales
            </p>
            <div>{{ $flashSales->links() }}</div>
        </div>

    </div>

@endsection
