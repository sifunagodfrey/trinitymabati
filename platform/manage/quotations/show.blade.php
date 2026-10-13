@extends('manage.layouts.app')

@section('title', $quotation->quotation_code . ' - Admin')

@section('content')

    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.quotations.index') }}" class="hover:text-primary">Quotations</a></li>
                <li>/</li>
                <li class="text-black font-semibold">{{ $quotation->quotation_code }}</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">{{ $quotation->quotation_code }}</h1>
                <p class="text-sm text-muted">Created {{ $quotation->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="flex items-center gap-2">
                @if ($quotation->status !== 'converted' && auth()->user()->hasPermission('manage_quotations'))
                    <form method="POST" action="{{ route('manage.quotations.convert', $quotation->id) }}"
                        onsubmit="return confirm('Convert this quotation into a real order?')">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
                            <i class="fa-solid fa-right-left"></i>
                            Convert to Order
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">

            <div class="bg-background border border-border rounded-[12px] shadow-sm overflow-hidden">
                <div class="p-5 border-b border-border">
                    <h2 class="text-base font-semibold text-black">Line Items</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm min-w-[560px]">
                        <thead class="bg-slate-50 border-b border-border">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wide">Item</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold text-muted uppercase tracking-wide">Qty</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold text-muted uppercase tracking-wide">Unit Price</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold text-muted uppercase tracking-wide">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @foreach ($quotation->items as $item)
                                <tr>
                                    <td class="px-5 py-3 text-black">{{ $item->item_name }}</td>
                                    <td class="px-5 py-3 text-right text-muted">{{ $item->quantity }}</td>
                                    <td class="px-5 py-3 text-right text-muted">{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="px-5 py-3 text-right text-black font-medium">{{ number_format($item->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-5 border-t border-border space-y-1 text-sm">
                    <div class="flex justify-between text-muted">
                        <span>Subtotal</span>
                        <span>KES {{ number_format($quotation->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-muted">
                        <span>Tax</span>
                        <span>KES {{ number_format($quotation->tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-muted">
                        <span>Discount</span>
                        <span>- KES {{ number_format($quotation->discount, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-black font-semibold text-base pt-2 border-t border-border">
                        <span>Total</span>
                        <span>KES {{ number_format($quotation->total, 2) }}</span>
                    </div>
                </div>
            </div>

            @if ($quotation->notes)
                <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                    <h2 class="text-base font-semibold text-black mb-2">Notes</h2>
                    <p class="text-sm text-muted whitespace-pre-line">{{ $quotation->notes }}</p>
                </div>
            @endif

        </div>

        <div class="space-y-6">

            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4">Status</h2>

                @if (auth()->user()->hasPermission('manage_quotations') && $quotation->status !== 'converted')
                    <form method="POST" action="{{ route('manage.quotations.status', $quotation->id) }}" class="flex gap-2">
                        @csrf
                        @method('PUT')
                        <select name="status"
                            class="flex-1 rounded-[12px] border border-border bg-white px-3 py-2 text-sm text-black outline-none transition focus:border-primary">
                            @foreach (['draft', 'sent', 'accepted', 'rejected', 'expired'] as $status)
                                <option value="{{ $status }}" {{ $quotation->status === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="rounded-[12px] bg-primary px-4 py-2 text-sm font-medium text-white transition hover:bg-primary-dark">
                            Update
                        </button>
                    </form>
                @else
                    <span class="inline-flex px-3 py-1.5 rounded-[12px] text-sm font-medium bg-purple-100 text-purple-700">
                        {{ ucfirst($quotation->status) }}
                    </span>
                @endif

                @if ($quotation->valid_until)
                    <p class="text-sm text-muted mt-4">Valid until {{ $quotation->valid_until->format('d M Y') }}</p>
                @endif

                @if ($quotation->convertedOrder)
                    <p class="text-sm text-muted mt-2">
                        Converted to order
                        <a href="{{ route('manage.ecommerce.orders.index') }}" class="text-primary hover:underline">
                            {{ $quotation->convertedOrder->order_code }}
                        </a>
                    </p>
                @endif
            </div>

            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4">Customer</h2>
                <p class="text-sm text-black font-medium">
                    {{ trim(($quotation->customer->first_name ?? '') . ' ' . ($quotation->customer->last_name ?? '')) ?: '—' }}
                </p>
                <p class="text-sm text-muted">{{ $quotation->customer->email ?? '' }}</p>
                <p class="text-sm text-muted">{{ $quotation->customer->phone ?? '' }}</p>
            </div>

            @if ($quotation->preparedBy)
                <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                    <h2 class="text-base font-semibold text-black mb-4">Prepared By</h2>
                    <p class="text-sm text-black font-medium">
                        {{ trim($quotation->preparedBy->first_name . ' ' . $quotation->preparedBy->last_name) }}
                    </p>
                    <p class="text-sm text-muted">{{ $quotation->preparedBy->email }}</p>
                </div>
            @endif

        </div>

    </div>

@endsection
