@extends('manage.layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $maxRevenue = max(1, (float) $salesChart->max('revenue'));
    $chartPoints = $salesChart->map(function ($item, $index) use ($maxRevenue) {
        $x = 24 + ($index * (852 / 11));
        $y = 250 - (($item['revenue'] / $maxRevenue) * 205);
        return round($x, 2) . ',' . round($y, 2);
    })->implode(' ');
    $areaPoints = '24,250 ' . $chartPoints . ' 876,250';
@endphp

<div class="admin-dashboard space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-primary">Store overview</p>
            <h1 class="mt-1 text-2xl font-bold text-text">Welcome back, {{ Auth::user()->name ?? 'Admin' }}</h1>
            <p class="mt-1 text-sm text-muted">Here is what is happening across {{ config('app.name') }} today.</p>
        </div>
        <div class="inline-flex items-center gap-2 self-start rounded-[8px] border border-border bg-white px-4 py-2 text-sm text-muted shadow-sm"><i class="fa-regular fa-calendar text-primary"></i>{{ now()->format('D, d M Y') }}</div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <a href="{{ route('manage.ecommerce.orders.index') }}" class="admin-stat-card admin-stat-primary"><span class="admin-stat-icon"><i class="fa-solid fa-cart-shopping"></i></span><span><span class="admin-stat-label">Total orders</span><strong>{{ number_format($totalOrders) }}</strong><small>{{ $ordersWeeklyGrowth >= 0 ? '↑' : '↓' }} {{ abs($ordersWeeklyGrowth) }}% this week</small></span></a>
        <a href="{{ route('manage.payments.transactions.index') }}" class="admin-stat-card admin-stat-secondary"><span class="admin-stat-icon"><i class="fa-solid fa-wallet"></i></span><span><span class="admin-stat-label">Total revenue</span><strong>KES {{ number_format($totalRevenue) }}</strong><small>{{ $revenueMonthlyGrowth >= 0 ? '↑' : '↓' }} {{ abs($revenueMonthlyGrowth) }}% this month</small></span></a>
        <a href="{{ route('manage.ecommerce.customers.index') }}" class="admin-stat-card admin-stat-tertiary"><span class="admin-stat-icon"><i class="fa-regular fa-user"></i></span><span><span class="admin-stat-label">Customers</span><strong>{{ number_format($totalCustomers) }}</strong><small>Registered shoppers</small></span></a>
        <a href="{{ route('manage.products.all.index') }}" class="admin-stat-card admin-stat-mixed"><span class="admin-stat-icon"><i class="fa-solid fa-box-open"></i></span><span><span class="admin-stat-label">Products</span><strong>{{ number_format($totalProducts) }}</strong><small>{{ number_format($lowStockCount) }} low stock</small></span></a>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <section class="admin-panel xl:col-span-2">
            <div class="admin-panel-heading"><div><h2>Sales performance</h2><p>Paid revenue over the last 12 months</p></div><span class="rounded-[12px] bg-primary-light px-3 py-1 text-xs font-semibold text-primary">KES {{ number_format($salesChart->sum('revenue')) }}</span></div>
            <div class="p-5"><div class="relative overflow-hidden rounded-[12px] bg-background p-3">
                <svg viewBox="0 0 900 275" class="h-64 w-full" role="img" aria-label="Twelve month revenue chart">
                    @foreach ([45, 96, 147, 198, 249] as $lineY)<line x1="24" y1="{{ $lineY }}" x2="876" y2="{{ $lineY }}" stroke="var(--border-color)" stroke-width="1" />@endforeach
                    <defs><linearGradient id="salesArea" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="var(--primary-color)" stop-opacity=".34" /><stop offset="100%" stop-color="var(--primary-color)" stop-opacity=".02" /></linearGradient></defs>
                    <polygon points="{{ $areaPoints }}" fill="url(#salesArea)" />
                    <polyline points="{{ $chartPoints }}" fill="none" stroke="var(--primary-color)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                    @foreach ($salesChart as $index => $item)
                        @php $x = 24 + ($index * (852 / 11)); $y = 250 - (($item['revenue'] / $maxRevenue) * 205); @endphp
                        <circle cx="{{ $x }}" cy="{{ $y }}" r="4" fill="white" stroke="var(--secondary-color)" stroke-width="3"><title>{{ $item['label'] }}: KES {{ number_format($item['revenue']) }}</title></circle>
                        <text x="{{ $x }}" y="270" text-anchor="middle" font-size="11" fill="var(--muted-color)">{{ $item['label'] }}</text>
                    @endforeach
                </svg>
            </div></div>
        </section>

        <section class="admin-panel">
            <div class="admin-panel-heading"><div><h2>Store activity</h2><p>Items needing attention</p></div></div>
            <div class="space-y-3 p-5">
                <a href="{{ route('manage.ecommerce.orders.index', ['pending_attention' => 1]) }}" class="admin-activity-row"><span class="bg-primary-light text-primary"><i class="fa-regular fa-clock"></i></span><div><strong>Pending orders</strong><small>Awaiting processing</small></div><b>{{ number_format($pendingOrders) }}</b></a>
                <a href="{{ route('manage.products.all.index', ['stock_status' => 'low']) }}" class="admin-activity-row"><span class="bg-secondary-light text-secondary"><i class="fa-solid fa-triangle-exclamation"></i></span><div><strong>Low stock</strong><small>Needs replenishing</small></div><b>{{ number_format($lowStockCount) }}</b></a>
                <a href="{{ route('manage.products.all.index') }}" class="admin-activity-row"><span class="bg-tertiary-light text-tertiary"><i class="fa-solid fa-boxes-stacked"></i></span><div><strong>Catalogue</strong><small>Active products</small></div><b>{{ number_format($totalProducts) }}</b></a>
            </div>
        </section>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <section class="admin-panel xl:col-span-2">
            <div class="admin-panel-heading"><div><h2>Recent orders</h2><p>Latest customer purchases</p></div><a href="{{ route('manage.ecommerce.orders.index') }}">View all <i class="fa-solid fa-arrow-right"></i></a></div>
            <div class="overflow-x-auto"><table class="w-full min-w-[650px] text-left text-sm"><thead><tr><th>Order</th><th>Customer</th><th>Status</th><th class="text-right">Amount</th></tr></thead><tbody>
                @forelse ($recentOrders as $order)
                    @php $statusClass = match($order->status) {'completed','delivered'=>'bg-emerald-100 text-emerald-700','processing'=>'bg-primary-light text-primary','cancelled'=>'bg-red-100 text-red-700',default=>'bg-secondary-light text-secondary-dark'}; @endphp
                    <tr onclick="window.location='{{ route('manage.ecommerce.orders.show', $order->id) }}'" class="cursor-pointer"><td class="font-semibold text-text">{{ $order->order_code }}</td><td>{{ $order->user?->name ?? 'Guest' }}</td><td><span class="rounded-[12px] px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span></td><td class="text-right font-semibold text-text">KES {{ number_format($order->total) }}</td></tr>
                @empty<tr><td colspan="4" class="py-12 text-center text-muted">No orders yet.</td></tr>@endforelse
            </tbody></table></div>
        </section>

        <section class="admin-panel">
            <div class="admin-panel-heading"><div><h2>Low stock</h2><p>Products to replenish</p></div><a href="{{ route('manage.products.all.index') }}">View all</a></div>
            <div class="divide-y divide-border px-5">
                @forelse ($lowStockProducts as $product)
                    <a href="{{ route('manage.products.all.show', $product->id) }}" class="flex items-center gap-3 py-4"><span class="flex h-10 w-10 items-center justify-center rounded-[8px] bg-primary-light text-primary"><i class="fa-solid fa-box"></i></span><span class="min-w-0 flex-1"><strong class="block truncate text-sm text-text">{{ $product->name }}</strong><small class="text-muted">{{ $product->sku }}</small></span><b class="rounded-[8px] bg-red-50 px-2 py-1 text-xs text-red-600">{{ $product->stock_quantity }} left</b></a>
                @empty<div class="py-12 text-center text-sm text-muted">Stock levels are healthy.</div>@endforelse
            </div>
        </section>
    </div>
</div>
@endsection
