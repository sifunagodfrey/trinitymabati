@extends('manage.layouts.app')

@section('title', 'Abandoned Carts - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.ecommerce.orders.index') }}" class="hover:text-primary">E-commerce</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Abandoned Carts</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Abandoned Carts</h1>
                <p class="text-sm text-muted">Checkouts where Mpesa payment failed - track and follow up with customers.</p>
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
    @if (session('error'))
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">

        {{-- ---------------
        -- Search + Recovered Filter
        -- --------------- --}}
        <form method="GET" action="{{ route('manage.ecommerce.abandoned-carts.index') }}"
              class="mb-6 flex flex-wrap items-center gap-3">

            <div class="flex-1 min-w-[220px] flex items-center bg-white border border-border rounded-[12px] overflow-hidden">
                <i class="fa-solid fa-magnifying-glass text-muted pl-4 pr-2 text-sm flex-shrink-0"></i>
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Search by customer name or email..."
                    class="flex-1 px-2 py-3 text-sm text-black outline-none bg-transparent border-0" />
                @if (request('search'))
                    <a href="{{ route('manage.ecommerce.abandoned-carts.index', request()->except(['search', 'page'])) }}"
                        class="pr-3 text-muted hover:text-red-400 transition text-xs">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>

            <select name="recovered" onchange="this.form.submit()"
                class="rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                <option value="">All Statuses</option>
                <option value="0" {{ request('recovered') === '0' ? 'selected' : '' }}>Not Recovered</option>
                <option value="1" {{ request('recovered') === '1' ? 'selected' : '' }}>Recovered</option>
            </select>

            <button type="submit"
                class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-3 text-sm font-medium text-white transition hover:bg-primary-dark">
                <i class="fa-solid fa-magnifying-glass"></i>
                Search
            </button>

            @if (request()->hasAny(['search', 'recovered']))
                <a href="{{ route('manage.ecommerce.abandoned-carts.index') }}"
                    class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-3 text-sm text-muted transition hover:bg-slate-100">
                    <i class="fa-solid fa-xmark"></i>
                    Clear
                </a>
            @endif

        </form>

        {{-- ---------------
        -- Abandoned Carts Table
        -- --------------- --}}
        <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[960px] divide-y divide-border text-sm">
                    <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                        <tr>
                            <th class="px-4 py-3">Order Code</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3 text-center">Items</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Failure Reason</th>
                            <th class="px-4 py-3 text-center">Recovered</th>
                            <th class="px-4 py-3 text-center">Reminder Sent</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border bg-white">
                        @forelse ($carts as $cart)
                            @php
                                // ---------------
                                // Decode cart_data safely
                                // ---------------
                                $data        = is_array($cart->cart_data) ? $cart->cart_data : [];
                                $itemCount   = $data['total_items'] ?? collect($data['items'] ?? [])->sum('quantity');
                                $total       = $data['total'] ?? 0;
                                $orderCode   = $data['order_code'] ?? '-';
                                $failReason  = $data['failure_reason'] ?? '-';
                            @endphp
                            <tr class="hover:bg-slate-50 cursor-pointer" onclick="window.location='{{ route('manage.ecommerce.abandoned-carts.show', $cart->id) }}'"  >
                                <td class="px-4 py-4">
                                    <span class="font-mono text-xs font-semibold text-black">
                                        {{ $orderCode }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    @if ($cart->user)
                                        <div class="font-medium text-black">
                                            {{ $cart->user->first_name }} {{ $cart->user->last_name }}
                                        </div>
                                        <div class="text-xs text-muted">{{ $cart->user->email }}</div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center text-sm text-black">
                                    {{ $itemCount }}
                                </td>
                                <td class="px-4 py-4 text-sm font-semibold text-black">
                                    KES {{ number_format($total, 2) }}
                                </td>
                                <td class="px-4 py-4 text-sm text-muted max-w-xs truncate" title="{{ $failReason }}">
                                    {{ $failReason }}
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if ($cart->recovered)
                                        <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold bg-emerald-100 text-emerald-800">Yes</span>
                                    @else
                                        <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold bg-rose-100 text-rose-800">No</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if ($cart->reminder_sent)
                                        <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-800">Sent</span>
                                    @else
                                        <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold bg-slate-100 text-slate-600">No</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-xs text-muted whitespace-nowrap">
                                    {{ $cart->created_at?->format('d M Y') ?? '-' }}
                                </td>
                                <td class="px-4 py-4 text-right" onclick="event.stopPropagation()">
                                    <a href="{{ route('manage.ecommerce.abandoned-carts.show', $cart->id) }}"
                                        title="View Details"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-border bg-background text-text transition hover:bg-slate-100">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-12 text-center text-sm text-muted">
                                    <div class="flex flex-col items-center gap-3">
                                        <i class="fa-solid fa-cart-shopping text-3xl text-slate-300"></i>
                                        <span>No abandoned carts found. Try adjusting your search or filters.</span>
                                        @if (request()->hasAny(['search', 'recovered']))
                                            <a href="{{ route('manage.ecommerce.abandoned-carts.index') }}"
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
                Showing {{ $carts->firstItem() ?? 0 }} – {{ $carts->lastItem() ?? 0 }}
                of {{ $carts->total() }} abandoned carts
            </p>
            <div>{{ $carts->links() }}</div>
        </div>

    </div>

@endsection
