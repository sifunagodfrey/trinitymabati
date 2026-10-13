@extends('manage.layouts.app')

@section('title', 'Return Request - ' . ($return->order?->order_code ?? '#' . $return->id) . ' - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.ecommerce.returns.index') }}" class="hover:text-primary">Returns</a></li>
                <li>/</li>
                <li class="text-black font-semibold">{{ $return->order?->order_code ?? '#' . $return->id }}</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('manage.ecommerce.returns.index') }}"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-muted hover:text-black transition">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Back
                </a>
                <div>
                    <h1 class="text-2xl font-semibold text-black">
                        Return: {{ $return->order?->order_code ?? '#' . $return->id }}
                    </h1>
                    <p class="text-sm text-muted">Requested {{ $return->created_at?->format('d M Y, H:i') ?? '-' }}</p>
                </div>
            </div>

            {{-- ---------------
            -- Status Badge
            -- --------------- --}}
            @php
                $statusColors = [
                    'requested' => 'bg-blue-100 text-blue-800',
                    'approved'  => 'bg-emerald-100 text-emerald-800',
                    'rejected'  => 'bg-rose-100 text-rose-800',
                    'refunded'  => 'bg-purple-100 text-purple-800',
                ];
            @endphp
            <span class="inline-flex rounded-[12px] px-4 py-1.5 text-xs font-semibold
                {{ $statusColors[$return->status] ?? 'bg-slate-100 text-slate-600' }}">
                {{ ucfirst($return->status ?? '-') }}
            </span>
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
    @if (session('warning'))
        <div class="mb-6 rounded-[12px] border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
            <span class="font-semibold">Warning:</span> {{ session('warning') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-6">

        {{-- ---------------
        -- Return Details & Customer
        -- --------------- --}}
        <div class="grid gap-6 lg:grid-cols-2">

            {{-- Return Details --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4">
                    <i class="fa-solid fa-rotate-left text-muted mr-2"></i>Return Details
                </h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Return ID</span>
                        <span class="font-medium text-black">#{{ $return->id }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Order Code</span>
                        <span class="font-mono font-semibold text-black">{{ $return->order?->order_code ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Status</span>
                        <span class="inline-flex rounded-[12px] px-3 py-0.5 text-xs font-semibold
                            {{ $statusColors[$return->status] ?? 'bg-slate-100 text-slate-600' }}">
                            {{ ucfirst($return->status ?? '-') }}
                        </span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Requested</span>
                        <span class="font-medium text-black">{{ $return->created_at?->format('d M Y, H:i') ?? '-' }}</span>
                    </div>
                </div>

                {{-- Reason --}}
                <div class="mt-4">
                    <p class="text-xs font-semibold text-muted uppercase tracking-wide mb-2">Reason</p>
                    <div class="rounded-[12px] bg-slate-50 px-4 py-4 text-sm text-black leading-relaxed">
                        {{ $return->reason ?? 'No reason provided.' }}
                    </div>
                </div>

                {{-- Approve / Reject / Refund Actions --}}
                @if ($return->status === 'requested')
                    <div class="mt-4 flex gap-2">
                        <form method="POST" action="{{ route('manage.ecommerce.returns.approve', $return->id) }}" class="flex-1">
                            @csrf
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 rounded-[12px] bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-emerald-700">
                                <i class="fa-solid fa-check"></i>
                                Approve Return
                            </button>
                        </form>
                        <form method="POST" action="{{ route('manage.ecommerce.returns.reject', $return->id) }}" class="flex-1"
                              onsubmit="return confirm('Reject this return request?')">
                            @csrf
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 rounded-[12px] border border-rose-200 bg-rose-50 px-4 py-2.5 text-sm font-medium text-rose-700 transition hover:bg-rose-100">
                                <i class="fa-solid fa-xmark"></i>
                                Reject Return
                            </button>
                        </form>
                    </div>
                @endif
                @if ($return->status === 'approved')
                    <div class="mt-4">
                        <form method="POST" action="{{ route('manage.ecommerce.returns.refund', $return->id) }}"
                              onsubmit="return confirm('Mark this return as refunded and notify the customer?')">
                            @csrf
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 rounded-[12px] bg-purple-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-purple-700">
                                <i class="fa-solid fa-money-bill-transfer"></i>
                                Mark as Refunded
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            {{-- Customer Info --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4">
                    <i class="fa-solid fa-user text-muted mr-2"></i>Customer
                </h2>
                @if ($return->user)
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                            <span class="text-muted">Name</span>
                            <span class="font-medium text-black">{{ $return->user->first_name }} {{ $return->user->last_name }}</span>
                        </div>
                        <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                            <span class="text-muted">Email</span>
                            <span class="font-medium text-black">{{ $return->user->email }}</span>
                        </div>
                        @if ($return->user->phone)
                            <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                                <span class="text-muted">Phone</span>
                                <a href="tel:{{ $return->user->phone }}"
                                    class="font-medium text-primary hover:underline">
                                    {{ $return->user->phone }}
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <p class="text-sm text-muted">Customer information not available.</p>
                @endif

                @if ($return->order)
                    <div class="mt-4">
                        <a href="{{ route('manage.ecommerce.orders.show', $return->order->id) }}"
                            class="inline-flex items-center gap-2 text-sm font-medium text-primary hover:underline">
                            <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                            View Original Order
                        </a>
                    </div>
                @endif
            </div>

        </div>

        {{-- ---------------
        -- Order Items
        -- --------------- --}}
        @if ($return->order && $return->order->items->isNotEmpty())
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4">Order Items</h2>
                <div class="overflow-hidden rounded-[12px] border border-border">
                    <div class="overflow-x-auto">
                        <table class="min-w-[560px] divide-y divide-border text-sm">
                            <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                                <tr>
                                    <th class="px-4 py-3">Product</th>
                                    <th class="px-4 py-3 text-center">Qty</th>
                                    <th class="px-4 py-3 text-right">Unit Price</th>
                                    <th class="px-4 py-3 text-right">Line Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border bg-white">
                                @foreach ($return->order->items as $item)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-4 py-3 font-medium text-black">
                                            {{ $item->product_name ?? '-' }}
                                            @if ($item->variant_label)
                                                <span class="ml-1 text-xs text-muted">({{ $item->variant_label }})</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center text-black">{{ number_format($item->quantity) }}</td>
                                        <td class="px-4 py-3 text-right text-black">{{ number_format($item->price, 2) }}</td>
                                        <td class="px-4 py-3 text-right font-semibold text-emerald-700">
                                            {{ number_format($item->quantity * $item->price, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

    </div>

@endsection
