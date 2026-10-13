@extends('manage.layouts.app')

@section('title', 'Ecommerce Reports - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Ecommerce Reports</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Ecommerce Reports</h1>
                <p class="text-sm text-muted">Monthly sales performance and platform metrics.</p>
            </div>
            <div class="flex gap-2">
                {{-- CSV Export Button --}}
                <button type="button"
                    x-data="{ exporting: false }"
                    @click="
                        exporting = true;
                        const link = document.createElement('a');
                        link.href = '{{ route('manage.ecommerce.reports.index', [...request()->all(), 'export' => 'csv']) }}';
                        link.setAttribute('download', '');
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        setTimeout(() => exporting = false, 4000);
                    "
                    :disabled="exporting"
                    class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-2.5 text-sm font-medium text-black transition hover:bg-slate-100 disabled:opacity-60 disabled:cursor-not-allowed">
                    <i x-show="!exporting" class="fa-solid fa-file-csv text-emerald-600"></i>
                    <i x-show="exporting" class="fa-solid fa-spinner fa-spin text-emerald-600"></i>
                    <span x-text="exporting ? 'Exporting...' : 'Export CSV'"></span>
                </button>

                {{-- PDF Export Button --}}
                <button type="button"
                    x-data="{ exporting: false }"
                    @click="
                        exporting = true;
                        const link = document.createElement('a');
                        link.href = '{{ route('manage.ecommerce.reports.index', [...request()->all(), 'export' => 'pdf']) }}';
                        link.setAttribute('download', '');
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        setTimeout(() => exporting = false, 4000);
                    "
                    :disabled="exporting"
                    class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-2.5 text-sm font-medium text-black transition hover:bg-slate-100 disabled:opacity-60 disabled:cursor-not-allowed">
                    <i x-show="!exporting" class="fa-solid fa-file-pdf text-red-600"></i>
                    <i x-show="exporting" class="fa-solid fa-spinner fa-spin text-red-600"></i>
                    <span x-text="exporting ? 'Exporting...' : 'Export PDF'"></span>
                </button>
            </div>
        </div>
    </div>

    {{-- ---------------
    -- Date Range Filter
    -- --------------- --}}
    <form method="GET" action="{{ route('manage.ecommerce.reports.index') }}"
          class="mb-6 flex flex-wrap items-end gap-3 bg-background border border-border rounded-[12px] p-4 shadow-sm">

        <div class="flex flex-col gap-1 flex-1 min-w-[160px]">
            <label class="text-xs font-semibold text-muted uppercase tracking-wide">Start Date</label>
            <input type="date" name="start_date" value="{{ $startDate }}"
                class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary" />
        </div>

        <div class="flex flex-col gap-1 flex-1 min-w-[160px]">
            <label class="text-xs font-semibold text-muted uppercase tracking-wide">End Date</label>
            <input type="date" name="end_date" value="{{ $endDate }}"
                class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary" />
        </div>

        <button type="submit"
            class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
            <i class="fa-solid fa-filter"></i>
            Filter
        </button>

        @if ($startDate || $endDate)
            <a href="{{ route('manage.ecommerce.reports.index') }}"
                class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-2.5 text-sm text-muted transition hover:bg-slate-100">
                <i class="fa-solid fa-xmark"></i>
                Reset
            </a>
        @endif

    </form>

    {{-- ---------------
    -- Summary Stat Cards
    -- --------------- --}}
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4 mb-6">

        <a href="{{ route('manage.ecommerce.orders.index') }}"
            class="bg-background border border-border rounded-[12px] p-5 shadow-sm text-center transition hover:shadow-md">
            <p class="text-xs text-muted uppercase tracking-wide">Total Orders</p>
            <p class="text-2xl font-bold text-primary mt-1">{{ number_format($totalOrders) }}</p>
        </a>

        <a href="{{ route('manage.ecommerce.orders.index', ['status' => 'completed']) }}"
            class="bg-background border border-border rounded-[12px] p-5 shadow-sm text-center transition hover:shadow-md">
            <p class="text-xs text-muted uppercase tracking-wide">Total Revenue</p>
            <p class="text-2xl font-bold text-emerald-600 mt-1">KES {{ number_format($totalRevenue, 0) }}</p>
        </a>

        <a href="{{ route('manage.ecommerce.customers.index') }}"
            class="bg-background border border-border rounded-[12px] p-5 shadow-sm text-center transition hover:shadow-md">
            <p class="text-xs text-muted uppercase tracking-wide">Customers</p>
            <p class="text-2xl font-bold text-blue-600 mt-1">{{ number_format($totalCustomers) }}</p>
        </a>

        <a href="{{ route('manage.ecommerce.returns.index') }}"
            class="bg-background border border-border rounded-[12px] p-5 shadow-sm text-center transition hover:shadow-md">
            <p class="text-xs text-muted uppercase tracking-wide">Refunds</p>
            <p class="text-2xl font-bold text-rose-600 mt-1">KES {{ number_format($totalRefunds, 0) }}</p>
        </a>

    </div>

    {{-- ---------------
    -- Monthly Sales Summary Table
    -- --------------- --}}
    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-semibold text-black">Monthly Sales Summary</h2>
            <span class="text-xs text-muted">Last 12 months</span>
        </div>

        <div class="overflow-hidden rounded-[12px] border border-border">
            <div class="overflow-x-auto">
                <table class="min-w-[560px] divide-y divide-border text-sm">
                    <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                        <tr>
                            <th class="px-4 py-3">Month</th>
                            <th class="px-4 py-3 text-center">Orders</th>
                            <th class="px-4 py-3 text-right">Revenue (KES)</th>
                            <th class="px-4 py-3 text-right">Refunds (KES)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border bg-white">
                        @forelse ($monthlyStats as $row)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 font-medium text-black">
                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $row->month)->format('F Y') }}
                                </td>
                                <td class="px-4 py-3 text-center text-black">{{ number_format($row->orders) }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-emerald-700">
                                    {{ number_format($row->revenue, 2) }}
                                </td>
                                <td class="px-4 py-3 text-right text-rose-600">
                                    {{ number_format($row->refunds, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-10 text-center text-sm text-muted">
                                    No data found for the selected date range.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
