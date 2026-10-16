@extends('manage.layouts.app')

@section('title', 'Customer - ' . $customer->first_name . ' ' . $customer->last_name . ' - Trinity Mabati Factory Admin')

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
                <li><a href="{{ route('manage.ecommerce.customers.index') }}" class="hover:text-primary">Customers</a></li>
                <li>/</li>
                <li class="text-black font-semibold">{{ $customer->first_name }} {{ $customer->last_name }}</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('manage.ecommerce.customers.index') }}"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-muted hover:text-black transition">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Back
                </a>
                <div>
                    <h1 class="text-2xl font-semibold text-black">{{ $customer->first_name }} {{ $customer->last_name }}</h1>
                    <p class="text-sm text-muted">Registered {{ $customer->created_at?->format('d M Y') ?? '-' }}</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                {{-- ---------------
                -- Message Button
                -- --------------- --}}
                <a href="{{ route('manage.ecommerce.customers.message', $customer->id) }}"
                    class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-4 py-2.5 text-sm font-medium text-black transition hover:bg-slate-100">
                    <i class="fa-solid fa-envelope text-primary"></i>
                    Send Message
                </a>

                {{-- ---------------
                -- Toggle Status
                -- --------------- --}}
                <form method="POST" action="{{ route('manage.ecommerce.customers.toggle-status', $customer->id) }}"
                      onsubmit="return confirm('Change this customer\'s status?')">
                    @csrf
                    @if ($customer->status === 'active')
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-[12px] border border-rose-200 bg-rose-50 px-4 py-2.5 text-sm font-medium text-rose-700 transition hover:bg-rose-100">
                            <i class="fa-solid fa-ban"></i>
                            Suspend
                        </button>
                    @else
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-[12px] border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm font-medium text-emerald-700 transition hover:bg-emerald-100">
                            <i class="fa-solid fa-circle-check"></i>
                            Activate
                        </button>
                    @endif
                </form>

                @if ($canDelete)
                    <form method="POST" action="{{ route('manage.ecommerce.customers.destroy', $customer->id) }}"
                          onsubmit="return confirm('Permanently delete this customer together with their orders, quotations and all other data? This cannot be undone.')">
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

    <div class="space-y-6">

        {{-- ---------------
        -- Profile Info Grid
        -- --------------- --}}
        <div class="grid gap-6 lg:grid-cols-2">

            {{-- Account Details --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4">
                    <i class="fa-solid fa-user text-muted mr-2"></i>Account Details
                </h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Full Name</span>
                        <span class="font-medium text-black">{{ $customer->first_name }} {{ $customer->last_name }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Email</span>
                        <span class="font-medium text-black">{{ $customer->email }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Phone</span>
                        <span class="font-medium text-black">{{ $customer->phone ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Registered</span>
                        <span class="font-medium text-black">{{ $customer->created_at?->format('d M Y') ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Last Login</span>
                        <span class="font-medium text-black">{{ $customer->last_login_at?->format('d M Y, H:i') ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Status</span>
                        @php
                            $statusColors = [
                                'active'    => 'bg-emerald-100 text-emerald-800',
                                'suspended' => 'bg-rose-100 text-rose-800',
                                'pending'   => 'bg-amber-100 text-amber-800',
                            ];
                        @endphp
                        <span class="inline-flex rounded-[12px] px-3 py-0.5 text-xs font-semibold
                            {{ $statusColors[$customer->status] ?? 'bg-slate-100 text-slate-600' }}">
                            {{ ucfirst($customer->status ?? 'pending') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Order Stats --}}
            <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-black mb-4">
                    <i class="fa-solid fa-chart-bar text-muted mr-2"></i>Order Summary
                </h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Total Orders</span>
                        <span class="font-semibold text-black">{{ number_format($orderStats->total_orders ?? 0) }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Total Spent</span>
                        <span class="font-semibold text-emerald-700">KES {{ number_format($orderStats->total_spent ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Completed Orders</span>
                        <span class="font-semibold text-black">{{ number_format($orderStats->completed_orders ?? 0) }}</span>
                    </div>
                    <div class="flex justify-between rounded-[12px] bg-slate-50 px-4 py-3">
                        <span class="text-muted">Cancelled Orders</span>
                        <span class="font-semibold text-rose-600">{{ number_format($orderStats->cancelled_orders ?? 0) }}</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- ---------------
        -- Order History
        -- --------------- --}}
        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
            <h2 class="text-base font-semibold text-black mb-4">Order History</h2>

            <div class="overflow-hidden rounded-[12px] border border-border">
                <div class="overflow-x-auto">
                    <table class="min-w-[720px] divide-y divide-border text-sm">
                        <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                            <tr>
                                <th class="px-4 py-3">Order Code</th>
                                <th class="px-4 py-3 text-right">Total</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Payment</th>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border bg-white">
                            @forelse ($orders as $order)
                                @php
                                    $orderStatusColors = [
                                        'pending'    => 'bg-amber-100 text-amber-800',
                                        'processing' => 'bg-blue-100 text-blue-800',
                                        'completed'  => 'bg-emerald-100 text-emerald-800',
                                        'cancelled'  => 'bg-rose-100 text-rose-800',
                                        'refunded'   => 'bg-purple-100 text-purple-800',
                                    ];
                                @endphp
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 font-mono text-xs font-semibold text-black">
                                        {{ $order->order_code ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-semibold text-emerald-700">
                                        KES {{ number_format($order->total ?? 0, 2) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex rounded-[12px] px-3 py-0.5 text-xs font-semibold
                                            {{ $orderStatusColors[$order->status] ?? 'bg-slate-100 text-slate-600' }}">
                                            {{ ucwords(str_replace('_', ' ', $order->status ?? '-')) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-xs text-black capitalize">
                                        {{ $order->payment_status ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-xs text-muted whitespace-nowrap">
                                        {{ $order->created_at?->format('d M Y') ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('manage.ecommerce.orders.show', $order->id) }}"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-[8px] border border-border bg-background text-text transition hover:bg-slate-100">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-sm text-muted">
                                        No orders found for this customer.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ---------------
        -- Message History
        -- --------------- --}}
        <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-semibold text-black">Message History</h2>
                <a href="{{ route('manage.ecommerce.customers.message', $customer->id) }}"
                    class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-4 py-2 text-xs font-medium text-white transition hover:bg-primary-dark">
                    <i class="fa-solid fa-plus"></i>
                    New Message
                </a>
            </div>

            @if ($messages->isEmpty())
                <p class="text-sm text-muted text-center py-8">No messages sent to this customer yet.</p>
            @else
                <div class="space-y-3">
                    @foreach ($messages as $msg)
                        <div class="rounded-[12px] border border-border bg-slate-50 px-4 py-4">
                            <div class="flex items-start justify-between gap-4 mb-2">
                                <p class="text-sm font-semibold text-black">{{ $msg->subject }}</p>
                                <span class="text-xs text-muted whitespace-nowrap">{{ $msg->created_at?->format('d M Y, H:i') ?? '-' }}</span>
                            </div>
                            <p class="text-sm text-black leading-relaxed">{{ $msg->message }}</p>
                            <p class="text-xs text-muted mt-2">
                                Sent by: Admin
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

@endsection
