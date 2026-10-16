@extends('manage.layouts.app')

@section('title', 'Orders - Trinity Mabati Factory Admin')

@section('content')

    @php $canDelete = auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'); @endphp

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Orders</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Orders</h1>
                <p class="text-sm text-muted">View and manage all customer orders.</p>
            </div>
        </div>
    </div>

    {{-- Session Alerts --}}
    @if (session('success'))
        <div class="mb-6 rounded-[12px] border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">{{ session('error') }}</div>
    @endif

    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">

        {{-- Search + Status Filters --}}
        <form method="GET" action="{{ route('manage.ecommerce.orders.index') }}" class="mb-6 flex flex-wrap items-center gap-3">
            <div class="flex-1 min-w-[220px] flex items-center bg-white border border-border rounded-[12px] overflow-hidden">
                <i class="fa-solid fa-magnifying-glass text-muted pl-4 pr-2 text-sm flex-shrink-0"></i>
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Search order code or customer..."
                    class="flex-1 px-2 py-3 text-sm text-black outline-none bg-transparent border-0" />
                @if (request('search'))
                    <a href="{{ route('manage.ecommerce.orders.index', request()->except(['search', 'page'])) }}"
                        class="pr-3 text-muted hover:text-red-400 transition text-xs">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>

            <select name="status" onchange="this.form.submit()" class="rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                <option value="">All Order Status</option>
                @foreach (['pending','processing','in_transit','delivered','completed','cancelled','refunded'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $s)) }}</option>
                @endforeach
            </select>

            <select name="payment_status" onchange="this.form.submit()" class="rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                <option value="">All Payment Status</option>
                @foreach (['pending','paid','processing','failed','refunded'] as $s)
                    <option value="{{ $s }}" {{ request('payment_status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>

            <button type="submit" class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-3 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-magnifying-glass"></i> Search
            </button>

            @if (request()->hasAny(['search', 'status', 'payment_status']))
                <a href="{{ route('manage.ecommerce.orders.index') }}" class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-3 text-sm text-muted transition hover:bg-slate-100">
                    <i class="fa-solid fa-xmark"></i> Clear
                </a>
            @endif
        </form>

        {{-- Orders Table --}}
        <form id="bulk-delete-form" method="POST" action="{{ route('manage.ecommerce.orders.bulk-destroy') }}">
        @csrf
        @if ($canDelete)
            @include('manage.partials.bulk-delete', ['noun' => 'orders', 'warning' => 'Their items, payment records and history will be deleted too.'])
        @endif
        <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[960px] divide-y divide-border text-sm">
                    <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                        <tr>
                            @if ($canDelete)
                                <th class="w-10 px-4 py-3"><input type="checkbox" class="bulk-check-all" aria-label="Select all orders"></th>
                            @endif
                            <th class="px-4 py-3">Order Code</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3 text-center">Items</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Order Status</th>
                            <th class="px-4 py-3">Payment</th>
                            <th class="px-4 py-3">Shipping</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border bg-white">
                        @forelse ($orders as $order)
                            @php
                                $orderColors = ['pending'=>'bg-amber-100 text-amber-800','processing'=>'bg-blue-100 text-blue-800','in_transit'=>'bg-purple-100 text-purple-800','delivered'=>'bg-indigo-100 text-indigo-800','completed'=>'bg-emerald-100 text-emerald-800','cancelled'=>'bg-rose-100 text-rose-800','refunded'=>'bg-orange-100 text-orange-800'];
                                $payColors = ['pending'=>'bg-amber-100 text-amber-800','paid'=>'bg-emerald-100 text-emerald-800','processing'=>'bg-blue-100 text-blue-800','failed'=>'bg-rose-100 text-rose-800','refunded'=>'bg-orange-100 text-orange-800'];
                                $shipColors = ['pending'=>'bg-amber-100 text-amber-800','shipped'=>'bg-blue-100 text-blue-800','in_transit'=>'bg-purple-100 text-purple-800','delivered'=>'bg-emerald-100 text-emerald-800','cancelled'=>'bg-rose-100 text-rose-800'];
                            @endphp
                            <tr class="hover:bg-slate-50 cursor-pointer" onclick="window.location='{{ route('manage.ecommerce.orders.show', $order->id) }}'">
                                @if ($canDelete)
                                    <td class="px-4 py-4" onclick="event.stopPropagation()"><input type="checkbox" name="ids[]" value="{{ $order->id }}" class="bulk-check" aria-label="Select order"></td>
                                @endif
                                <td class="px-4 py-4"><span class="font-mono text-xs font-semibold text-black">{{ $order->order_code ?? '#' . $order->id }}</span></td>
                                <td class="px-4 py-4">
                                    @if ($order->user)
                                        <div class="font-medium text-black">{{ $order->user->first_name }} {{ $order->user->last_name }}</div>
                                        <div class="text-xs text-muted">{{ $order->user->email }}</div>
                                    @else <span class="text-muted">-</span> @endif
                                </td>
                                <td class="px-4 py-4 text-center text-sm text-black">{{ $order->items_count }}</td>
                                <td class="px-4 py-4 text-sm font-semibold text-black">KES {{ number_format($order->total ?? 0, 2) }}</td>
                                <td class="px-4 py-4"><span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold {{ $orderColors[$order->status] ?? 'bg-slate-100 text-slate-600' }}">{{ ucwords(str_replace('_', ' ', $order->status ?? 'pending')) }}</span></td>
                                <td class="px-4 py-4"><span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold {{ $payColors[$order->payment_status] ?? 'bg-slate-100 text-slate-600' }}">{{ ucfirst($order->payment_status ?? 'pending') }}</span></td>
                                <td class="px-4 py-4"><span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold {{ $shipColors[$order->shipping_status] ?? 'bg-slate-100 text-slate-600' }}">{{ ucwords(str_replace('_', ' ', $order->shipping_status ?? 'pending')) }}</span></td>
                                <td class="px-4 py-4 text-xs text-muted whitespace-nowrap">{{ $order->created_at?->format('d M Y') ?? '-' }}</td>
                                <td class="px-4 py-4 text-right" onclick="event.stopPropagation()">
                                    <a href="{{ route('manage.ecommerce.orders.show', $order->id) }}" title="View Order" class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-border bg-background text-text transition hover:bg-slate-100"><i class="fa-solid fa-eye text-xs"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="{{ $canDelete ? 10 : 9 }}" class="px-4 py-12 text-center text-sm text-muted">
                                <div class="flex flex-col items-center gap-3"><i class="fa-solid fa-box-open text-3xl text-slate-300"></i><span>No orders found.</span>
                                @if (request()->hasAny(['search', 'status', 'payment_status']))<a href="{{ route('manage.ecommerce.orders.index') }}" class="text-xs text-primary hover:underline">Clear filters</a>@endif</div>
                             </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        </form>

        <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-muted">Showing {{ $orders->firstItem() ?? 0 }} â€“ {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} orders</p>
            <div>{{ $orders->links() }}</div>
        </div>

    </div>

@endsection
