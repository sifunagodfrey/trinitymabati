@extends('manage.layouts.app')

@section('title', 'Abandoned Cart Detail - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb, Back Button & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.ecommerce.orders.index') }}" class="hover:text-primary">E-commerce</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.ecommerce.abandoned-carts.index') }}" class="hover:text-primary">Abandoned Carts</a></li>
                <li>/</li>
                <li class="text-black font-semibold">#{{ $cart->id }}</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Abandoned Cart #{{ $cart->id }}</h1>
                <p class="text-sm text-muted">Failed Mpesa payment - recorded {{ $cart->created_at?->format('d M Y, H:i') ?? '-' }}</p>
            </div>
            <a href="{{ route('manage.ecommerce.abandoned-carts.index') }}"
                class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-2.5 text-sm text-black transition hover:bg-slate-100">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Back
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

    @php
        // ---------------
        // Decode cart_data safely
        // ---------------
        $data         = is_array($cart->cart_data) ? $cart->cart_data : [];
        $items        = $data['items'] ?? [];
        $orderCode    = $data['order_code'] ?? '-';
        $total        = $data['total'] ?? 0;
        $totalItems   = $data['total_items'] ?? collect($items)->sum('quantity');
        $payMethod    = $data['payment_method'] ?? '-';
        $failReason   = $data['failure_reason'] ?? '-';
        $orderId      = $data['order_id'] ?? null;
    @endphp

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- ---------------
        -- Left column: Cart & Items
        -- --------------- --}}
        <div class="lg:col-span-2 flex flex-col gap-6">

            {{-- Cart Summary --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4">Cart Summary</h2>

                <dl class="grid grid-cols-1 gap-y-3 sm:grid-cols-2 text-sm">
                    <div>
                        <dt class="text-muted">Order Code</dt>
                        <dd class="font-mono font-semibold text-black">{{ $orderCode }}</dd>
                    </div>
                    <div>
                        <dt class="text-muted">Total</dt>
                        <dd class="font-semibold text-black">KES {{ number_format($total, 2) }}</dd>
                    </div>
                    <div>
                        <dt class="text-muted">Total Items</dt>
                        <dd class="font-semibold text-black">{{ $totalItems }}</dd>
                    </div>
                    <div>
                        <dt class="text-muted">Payment Method</dt>
                        <dd class="text-black capitalize">{{ $payMethod }}</dd>
                    </div>
                    <div>
                        <dt class="text-muted">Failure Reason</dt>
                        <dd class="text-rose-700">{{ $failReason }}</dd>
                    </div>
                    <div>
                        <dt class="text-muted">Recovered</dt>
                        <dd>
                            @if ($cart->recovered)
                                <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold bg-emerald-100 text-emerald-800">Yes</span>
                            @else
                                <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold bg-rose-100 text-rose-800">No</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-muted">Reminder Sent</dt>
                        <dd>
                            @if ($cart->reminder_sent)
                                <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-800">Sent</span>
                            @else
                                <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold bg-slate-100 text-slate-600">No</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- Items in Cart --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4">Items</h2>

                @if (count($items) > 0)
                    <div class="overflow-x-auto rounded-[12px] border border-border">
                        <table class="min-w-[600px] divide-y divide-border text-sm">
                            <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                                <tr>
                                    <th class="px-4 py-3">Product</th>
                                    <th class="px-4 py-3">Variant</th>
                                    <th class="px-4 py-3 text-center">Qty</th>
                                    <th class="px-4 py-3 text-right">Unit Price</th>
                                    <th class="px-4 py-3 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border bg-white">
                                @foreach ($items as $item)
                                    <tr>
                                        <td class="px-4 py-3 font-medium text-black">
                                            {{ $item['product_name'] ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-muted text-xs">
                                            {{ $item['variant_label'] ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-center text-black">
                                            {{ $item['quantity'] ?? 1 }}
                                        </td>
                                        <td class="px-4 py-3 text-right text-black">
                                            KES {{ number_format($item['price'] ?? 0, 2) }}
                                        </td>
                                        <td class="px-4 py-3 text-right font-semibold text-black">
                                            KES {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-background">
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-right text-sm font-semibold text-black">Total</td>
                                    <td class="px-4 py-3 text-right text-sm font-bold text-black">
                                        KES {{ number_format($total, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <p class="text-sm text-muted">No item data recorded for this cart.</p>
                @endif
            </div>

            {{-- Product Logs --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4">Product Log Entries</h2>

                @if ($logs->isNotEmpty())
                    <div class="overflow-x-auto rounded-[12px] border border-border">
                        <table class="min-w-full divide-y divide-border text-sm">
                            <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                                <tr>
                                    <th class="px-4 py-3">Product</th>
                                    <th class="px-4 py-3">Recorded At</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border bg-white">
                                @foreach ($logs as $log)
                                    <tr>
                                        <td class="px-4 py-3 text-black">
                                            {{ optional($log->product)->name ?? 'Product #' . $log->product_id }}
                                        </td>
                                        <td class="px-4 py-3 text-xs text-muted whitespace-nowrap">
                                            {{ $log->sent_at?->format('d M Y, H:i') ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-sm text-muted">No log entries for this cart.</p>
                @endif
            </div>

        </div>

        {{-- ---------------
        -- Right column: Customer & Actions
        -- --------------- --}}
        <div class="flex flex-col gap-6">

            {{-- Customer Info --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4">Customer</h2>

                @if ($cart->user)
                    <dl class="flex flex-col gap-3 text-sm">
                        <div>
                            <dt class="text-muted">Name</dt>
                            <dd class="font-medium text-black">
                                {{ $cart->user->first_name }} {{ $cart->user->last_name }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-muted">Email</dt>
                            <dd class="text-black break-all">{{ $cart->user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-muted">Phone</dt>
                            <dd class="text-black">{{ $cart->user->phone ?? '-' }}</dd>
                        </div>
                    </dl>
                @else
                    <p class="text-sm text-muted">Customer not found.</p>
                @endif
            </div>

            {{-- Actions --}}
            @if (!$cart->recovered)
                <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                    <h2 class="text-base font-semibold text-black mb-4">Actions</h2>

                    <form method="POST"
                          action="{{ route('manage.ecommerce.abandoned-carts.mark-recovered', $cart->id) }}">
                        @csrf
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('manage.ecommerce.abandoned-carts.index') }}"
                                class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-2.5 text-sm text-black transition hover:bg-slate-100">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center gap-2 rounded-[12px] bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-emerald-700">
                                <i class="fa-solid fa-check text-xs"></i>
                                Mark as Recovered
                            </button>
                        </div>
                    </form>
                </div>
            @endif

        </div>

    </div>

@endsection
