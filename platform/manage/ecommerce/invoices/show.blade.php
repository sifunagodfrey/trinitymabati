@extends('manage.layouts.app')

@section('title', 'Invoice - ' . ($order->order_code ?? '#' . $order->id) . ' - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.ecommerce.invoices.index') }}" class="hover:text-primary">Invoices</a></li>
                <li>/</li>
                <li class="text-black font-semibold">{{ $order->order_code ?? '#' . $order->id }}</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('manage.ecommerce.invoices.index') }}"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-muted hover:text-black transition">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Back
                </a>
                <div>
                    <h1 class="text-2xl font-semibold text-black">Invoice: {{ $order->order_code ?? '#' . $order->id }}</h1>
                    <p class="text-sm text-muted">Issued {{ $order->created_at?->format('d M Y') ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6">

        {{-- ---------------
        -- Customer & Order Info
        -- --------------- --}}
        <div class="grid gap-6 lg:grid-cols-2">

            {{-- Customer --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4">
                    <i class="fa-solid fa-user text-muted mr-2"></i>Customer
                </h2>
                @if ($order->user)
                    <div class="space-y-2 text-sm">
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
                            <span class="font-medium text-black">{{ $order->user->phone ?? '-' }}</span>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-muted">No customer information available.</p>
                @endif
            </div>

            {{-- Order Info --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4">
                    <i class="fa-solid fa-receipt text-muted mr-2"></i>Order Info
                </h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Order Status</span>
                        <span class="font-medium text-black capitalize">{{ ucwords(str_replace('_', ' ', $order->status ?? '-')) }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Payment Status</span>
                        <span class="font-medium text-black capitalize">{{ ucfirst($order->payment_status ?? '-') }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Currency</span>
                        <span class="font-medium text-black">{{ $order->currency ?? 'KES' }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">VAT Rate</span>
                        <span class="font-medium text-black">{{ number_format($vatRate, 2) }}%</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- ---------------
        -- Line Items Table
        -- --------------- --}}
        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
            <h2 class="text-base font-semibold text-black mb-4">Order Items</h2>
            <div class="overflow-x-auto">
                <table class="min-w-[960px] divide-y divide-border text-sm">
                    <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-muted">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Item</th>
                            <th class="px-4 py-3 text-center">Qty</th>
                            <th class="px-4 py-3 text-right">Unit (Gross)</th>
                            <th class="px-4 py-3 text-right">Line Gross</th>
                            <th class="px-4 py-3 text-right">VAT</th>
                            <th class="px-4 py-3 text-right">Comm.%</th>
                            <th class="px-4 py-3 text-right">Commission</th>
                            <th class="px-4 py-3 text-right">Vendor Net</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border bg-white">
                        @forelse ($calcItems as $i => $item)
                            <tr>
                                <td class="px-4 py-3 text-muted">{{ $i + 1 }}</td>
                                <td class="px-4 py-3 font-medium text-black">{{ $item->name }}</td>
                                <td class="px-4 py-3 text-center text-black">{{ number_format($item->qty) }}</td>
                                <td class="px-4 py-3 text-right text-black">{{ number_format($item->unit, 2) }}</td>
                                <td class="px-4 py-3 text-right text-black">{{ number_format($item->line, 2) }}</td>
                                <td class="px-4 py-3 text-right text-amber-700">{{ number_format($item->vat, 2) }}</td>
                                <td class="px-4 py-3 text-right text-muted">{{ number_format($item->rate_pct, 2) }}%</td>
                                <td class="px-4 py-3 text-right text-blue-700">{{ number_format($item->commission, 2) }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-emerald-700">{{ number_format($item->vendor, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-8 text-center text-sm text-muted">No items found for this invoice.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if (count($calcItems) > 0)
                        <tfoot class="bg-background">
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-right text-xs font-semibold uppercase text-muted">Totals</td>
                                <td class="px-4 py-3 text-right font-semibold text-black">{{ number_format($subtotal, 2) }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-amber-700">{{ number_format($vatTotal, 2) }}</td>
                                <td class="px-4 py-3"></td>
                                <td class="px-4 py-3 text-right font-semibold text-blue-700">{{ number_format($commissionTotal, 2) }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-emerald-700">{{ number_format($vendorTotal, 2) }}</td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>

        {{-- ---------------
        -- Invoice Summary & Earnings Breakdown
        -- --------------- --}}
        <div class="grid gap-6 lg:grid-cols-2">

            {{-- Invoice Summary --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4">Invoice Summary</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Items Subtotal (Gross)</span>
                        <span class="text-black">{{ $order->currency ?? 'KES' }} {{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">VAT ({{ number_format($vatRate, 2) }}%)</span>
                        <span class="text-amber-700">{{ $order->currency ?? 'KES' }} {{ number_format($vatTotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Shipping</span>
                        <span class="text-black">{{ $order->currency ?? 'KES' }} {{ number_format($shipping, 2) }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Discount</span>
                        <span class="text-rose-600">- {{ $order->currency ?? 'KES' }} {{ number_format($discount, 2) }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-primary/10 px-4 py-3 font-semibold">
                        <span class="text-black">Grand Total</span>
                        <span class="text-black">{{ $order->currency ?? 'KES' }} {{ number_format($grandTotal, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Internal Earnings --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4">Internal Earnings Breakdown</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Commission (Trinity Mabati Factory)</span>
                        <span class="font-semibold text-blue-700">{{ $order->currency ?? 'KES' }} {{ number_format($commissionTotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Vendor Earnings (after VAT & Comm.)</span>
                        <span class="font-semibold text-emerald-700">{{ $order->currency ?? 'KES' }} {{ number_format($vendorTotal, 2) }}</span>
                    </div>
                </div>

                @if ($order->notes)
                    <div class="mt-4 rounded-[12px] bg-amber-50 border border-amber-100 px-4 py-3">
                        <div class="text-xs font-semibold uppercase tracking-wide text-amber-700 mb-1">Customer Notes</div>
                        <p class="text-sm text-amber-900">{{ $order->notes }}</p>
                    </div>
                @endif

                <p class="mt-4 text-xs text-muted italic">
                    Calculated at render-time from the active VAT rate and product category commission.
                </p>
            </div>

        </div>

    </div>

@endsection
