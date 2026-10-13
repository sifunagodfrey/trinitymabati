@extends('manage.layouts.app')

@section('title', 'VAT Orders - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li class="text-black font-semibold">VAT Orders</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">VAT Orders</h1>
                <p class="text-sm text-muted">
                    Completed orders with VAT-applicable items. Current VAT rate:
                    <span class="font-semibold text-black">{{ number_format($vatRate, 2) }}%</span>
                </p>
            </div>
        </div>
    </div>

    {{-- ---------------
    -- Date Range Filter
    -- --------------- --}}
    <form method="GET" action="{{ route('manage.ecommerce.vat-orders.index') }}"
          class="mb-6 flex flex-wrap items-end gap-3 bg-background border border-border rounded-[12px] p-4 shadow-sm">

        <div class="flex flex-col gap-1 flex-1 min-w-[160px]">
            <label class="text-xs font-semibold text-muted uppercase tracking-wide">Start Date</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}"
                class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary" />
        </div>

        <div class="flex flex-col gap-1 flex-1 min-w-[160px]">
            <label class="text-xs font-semibold text-muted uppercase tracking-wide">End Date</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}"
                class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary" />
        </div>

        <button type="submit"
            class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
            <i class="fa-solid fa-filter"></i>
            Filter
        </button>

        @if (request('start_date') || request('end_date'))
            <a href="{{ route('manage.ecommerce.vat-orders.index') }}"
                class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-2.5 text-sm text-muted transition hover:bg-slate-100">
                <i class="fa-solid fa-xmark"></i>
                Reset
            </a>
        @endif

    </form>

    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">

        {{-- ---------------
        -- VAT Orders Table
        -- --------------- --}}
        <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[840px] divide-y divide-border text-sm">
                    <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                        <tr>
                            <th class="px-4 py-3">Order Code</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3 text-right">Subtotal</th>
                            <th class="px-4 py-3 text-right">VAT ({{ number_format($vatRate, 2) }}%)</th>
                            <th class="px-4 py-3 text-right">Grand Total</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border bg-white">
                        @forelse ($orders as $row)
                            <tr class="hover:bg-slate-50 cursor-pointer" onclick="window.location='{{ route('manage.ecommerce.orders.show', $row->order_id) }}'"  >
                                <td class="px-4 py-4 font-mono text-xs font-semibold text-black">
                                    {{ $row->order_code ?? '-' }}
                                </td>
                                <td class="px-4 py-4">
                                    <div class="font-medium text-black">
                                        {{ trim(($row->first_name ?? '') . ' ' . ($row->last_name ?? '')) ?: '-' }}
                                    </div>
                                    <div class="text-xs text-muted">{{ $row->email ?? '-' }}</div>
                                </td>
                                <td class="px-4 py-4 text-right text-sm text-black">
                                    {{ number_format($row->subtotal ?? 0, 2) }}
                                </td>
                                <td class="px-4 py-4 text-right font-semibold text-amber-700">
                                    {{ number_format($row->vat_amount ?? 0, 2) }}
                                </td>
                                <td class="px-4 py-4 text-right font-semibold text-emerald-700">
                                    {{ number_format($row->grand_total ?? 0, 2) }}
                                </td>
                                <td class="px-4 py-4 text-xs text-muted whitespace-nowrap">
                                    {{ $row->order_date ? \Carbon\Carbon::parse($row->order_date)->format('d M Y') : '-' }}
                                </td>
                                <td class="px-4 py-4 text-right" onclick="event.stopPropagation()">
                                    <a href="{{ route('manage.ecommerce.orders.show', $row->order_id) }}"
                                        title="View Order"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-border bg-background text-text transition hover:bg-slate-100">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center text-sm text-muted">
                                    <div class="flex flex-col items-center gap-3">
                                        <i class="fa-solid fa-receipt text-3xl text-slate-300"></i>
                                        <span>No VAT orders found for the selected period.</span>
                                        @if (request('start_date') || request('end_date'))
                                            <a href="{{ route('manage.ecommerce.vat-orders.index') }}"
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
                Showing {{ $orders->firstItem() ?? 0 }} – {{ $orders->lastItem() ?? 0 }}
                of {{ $orders->total() }} orders
            </p>
            <div>{{ $orders->appends(request()->query())->links() }}</div>
        </div>

    </div>

@endsection
