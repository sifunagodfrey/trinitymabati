@extends('manage.layouts.app')

@section('title', 'Order #' . ($order->order_code ?? $order->id) . ' - Trinity Mabati Factory Admin')

@section('content')

    @php $canDelete = auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'); @endphp

    @php
        // Status badge colour maps
        $orderColors = [
            'pending'    => 'bg-amber-100 text-amber-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'in_transit' => 'bg-purple-100 text-purple-800',
            'delivered'  => 'bg-indigo-100 text-indigo-800',
            'completed'  => 'bg-emerald-100 text-emerald-800',
            'cancelled'  => 'bg-rose-100 text-rose-800',
            'refunded'   => 'bg-orange-100 text-orange-800',
        ];
        $payColors = [
            'pending'    => 'bg-amber-100 text-amber-800',
            'paid'       => 'bg-emerald-100 text-emerald-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'failed'     => 'bg-rose-100 text-rose-800',
            'refunded'   => 'bg-orange-100 text-orange-800',
        ];
        $shipColors = [
            'pending'    => 'bg-amber-100 text-amber-800',
            'shipped'    => 'bg-blue-100 text-blue-800',
            'in_transit' => 'bg-purple-100 text-purple-800',
            'delivered'  => 'bg-emerald-100 text-emerald-800',
            'cancelled'  => 'bg-rose-100 text-rose-800',
        ];
    @endphp

    {{-- Breadcrumb & Header --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.ecommerce.orders.index') }}" class="hover:text-primary">Orders</a></li>
                <li>/</li>
                <li class="text-black font-semibold">{{ $order->order_code ?? '#' . $order->id }}</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('manage.ecommerce.orders.index') }}"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-muted hover:text-black transition">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Back
                </a>
                <div>
                    <h1 class="text-2xl font-semibold text-black">
                        Order {{ $order->order_code ?? '#' . $order->id }}
                    </h1>
                    <p class="text-sm text-muted">Placed on {{ $order->created_at?->format('d M Y, g:i A') ?? '-' }}</p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold
                    {{ $orderColors[$order->status] ?? 'bg-slate-100 text-slate-600' }}">
                    {{ ucwords(str_replace('_', ' ', $order->status ?? 'pending')) }}
                </span>
                <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold
                    {{ $payColors[$order->payment_status] ?? 'bg-slate-100 text-slate-600' }}">
                    {{ ucfirst($order->payment_status ?? 'pending') }}
                </span>
                <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold
                    {{ $shipColors[$order->shipping_status] ?? 'bg-slate-100 text-slate-600' }}">
                    {{ ucwords(str_replace('_', ' ', $order->shipping_status ?? 'pending')) }}
                </span>

                @if ($canDelete)
                    <form method="POST" action="{{ route('manage.ecommerce.orders.destroy', $order->id) }}"
                          onsubmit="return confirm('Permanently delete this order with its items, payments and history? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-[12px] border border-rose-200 bg-white px-4 py-2.5 text-sm font-medium text-rose-700 transition hover:bg-rose-50">
                            <i class="fa-solid fa-trash"></i>
                            Delete
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    {{-- Session Alerts --}}
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

    <div class="space-y-6">

        {{-- Update Status Form (unchanged) --}}
        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
            <h2 class="text-base font-semibold text-black mb-4">Update Order Status</h2>
            <form action="{{ route('manage.ecommerce.orders.update-status', $order->id) }}" method="POST">
                @csrf
                <div class="grid gap-4 sm:grid-cols-3">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wide text-muted mb-1">Order Status</label>
                        <select name="status" class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                            @foreach ($orderStatuses as $s)
                                <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $s)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wide text-muted mb-1">Payment Status</label>
                        <select name="payment_status" class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                            @foreach ($paymentStatuses as $s)
                                <option value="{{ $s }}" {{ $order->payment_status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wide text-muted mb-1">Shipping Status</label>
                        <select name="shipping_status" class="w-full rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                            @foreach ($shippingStatuses as $s)
                                <option value="{{ $s }}" {{ $order->shipping_status === $s ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $s)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4 flex justify-end gap-3">
                    <a href="{{ route('manage.ecommerce.orders.index') }}" class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-5 py-2.5 text-sm font-medium text-text transition hover:bg-slate-100">Cancel</a>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-5 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
                        <i class="fa-solid fa-floppy-disk"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>

        {{-- Customer Card --}}
        <div class="grid gap-6">

            {{-- Customer --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4"><i class="fa-solid fa-user text-muted mr-2"></i>Customer</h2>
                @if ($order->user)
                    <div class="grid gap-3 text-sm sm:grid-cols-3">
                        <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                            <span class="text-muted">Name</span>
                            <span class="font-medium text-black">{{ $order->user->first_name }} {{ $order->user->last_name }}</span>
                        </div>
                        <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                            <span class="text-muted">Email</span>
                            <span class="font-medium text-black">{{ $order->user->email }}</span>
                        </div>
                        <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                            <span class="text-muted">Phone</span>
                            <span class="font-medium text-black">{{ $order->phone ?? $order->user->phone ?? '-' }}</span>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-muted">No customer information available.</p>
                @endif
            </div>
        </div>

        {{-- Order Items Table --}}
        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
            <h2 class="text-base font-semibold text-black mb-4">Order Items</h2>
            <div class="overflow-x-auto">
                <table class="min-w-[600px] divide-y divide-border text-sm">
                    <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-muted">
                        <tr>
                            <th class="px-4 py-3">Product</th>
                            <th class="px-4 py-3">Variant</th>
                            <th class="px-4 py-3 text-center">Qty</th>
                            <th class="px-4 py-3 text-right">Unit Price</th>
                            <th class="px-4 py-3 text-right">Line Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border bg-white">
                        @forelse ($order->items as $item)
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="font-medium text-black">{{ $item->product_name }}</div>
                                    @if ($item->product)
                                        <div class="text-xs text-muted">SKU: {{ $item->product->sku ?? '-' }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-sm text-muted">
                                    {{ $item->variant_label ?? '-' }}
                                </td>
                                <td class="px-4 py-4 text-center text-sm text-black">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-4 py-4 text-right text-sm text-black">
                                    KES {{ number_format($item->price ?? 0, 2) }}
                                </td>
                                <td class="px-4 py-4 text-right text-sm font-semibold text-black">
                                    KES {{ number_format(($item->price ?? 0) * ($item->quantity ?? 1), 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-muted">No items found for this order.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Order Totals & Details --}}
        <div class="grid gap-6 lg:grid-cols-2">

            {{-- Totals --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4">Order Totals</h2>
                @php
                    $subtotal = $order->items->sum(fn($i) => $i->price * $i->quantity);
                @endphp
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Subtotal</span>
                        <span class="text-black">KES {{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Shipping Cost</span>
                        <span class="text-black">KES {{ number_format($order->shipping_cost ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Tax</span>
                        <span class="text-black">KES {{ number_format($order->tax ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Discount</span>
                        <span class="text-black">- KES {{ number_format($order->discount ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-primary/10 px-4 py-3 font-semibold">
                        <span class="text-black">Total</span>
                        <span class="text-black">KES {{ number_format($order->total ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Payment & Delivery Details (with payment method) --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4">Payment & Delivery</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Payment Method</span>
                        <span class="font-medium text-black">{{ $paymentMethod ?? '-' }}</span>
                    </div>
                    @if($paymentRef)
                        <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                            <span class="text-muted">Transaction Reference</span>
                            <span class="font-mono text-xs text-black">{{ $paymentRef }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Mpesa Checkout Request ID</span>
                        <span class="font-mono text-xs text-black">{{ $order->mpesa_checkout_request_id ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Co-op Bank Message Reference</span>
                        <span class="font-mono text-xs text-black">{{ $order->coopbank_message_reference ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Expected Delivery</span>
                        <span class="text-black">
                            {{ $order->expected_delivery ? \Carbon\Carbon::parse($order->expected_delivery)->format('d M Y') : '-' }}
                        </span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Customer Confirmed</span>
                        <span class="font-semibold {{ $order->customer_confirmed === 'yes' ? 'text-emerald-700' : 'text-muted' }}">
                            {{ ucfirst($order->customer_confirmed ?? 'no') }}
                        </span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Admin Confirmed</span>
                        <span class="font-semibold {{ $order->admin_confirmed === 'yes' ? 'text-emerald-700' : 'text-muted' }}">
                            {{ ucfirst($order->admin_confirmed ?? 'no') }}
                        </span>
                    </div>
                </div>

                @if ($order->notes)
                    <div class="mt-4 rounded-[12px] bg-amber-50 border border-amber-100 px-4 py-3">
                        <div class="text-xs font-semibold uppercase tracking-wide text-amber-700 mb-1">Order Notes</div>
                        <p class="text-sm text-amber-900">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

@endsection
