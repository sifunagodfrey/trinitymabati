{{-- -------------------
     Client Dashboard
------------------- --}}
@extends('client.layouts.app')

@section('title', 'My Dashboard')

@section('content')

    <div class="max-w-7xl mx-auto px-6 py-8 space-y-6 text-text">

        {{-- Page Heading --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ Auth::user()->first_name ?? Auth::user()->name }}</h1>
            <p class="text-gray-500 text-sm mt-1">Here's an overview of your account activity.</p>
        </div>

        {{-- =========================
         SUMMARY CARDS
    ========================= --}}
        <div class="grid grid-cols-1 gap-5">

            {{-- Total Orders --}}
            <a href="{{ route('client.orders.index') }}" class="bg-white border border-gray-200 p-5 rounded-[8px] block hover:opacity-90 transition">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm text-gray-500">Total Orders</p>
                    <div class="w-9 h-9 rounded-[12px] bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-shopping-bag text-sm text-gray-600"></i>
                    </div>
                </div>
                <p class="text-2xl font-extrabold text-gray-900">{{ $orderCount }}</p>
                <span class="text-xs text-gray-400 mt-1 inline-block">View Orders &rarr;</span>
            </a>

        </div>

        {{-- =========================
         QUICK ACTIONS
    ========================= --}}
        <div class="bg-white border border-gray-200 rounded-[8px] p-6">

            <h2 class="font-bold text-gray-900 mb-4">Quick Actions</h2>

            <div class="grid grid-cols-2 gap-3">

                <a href="{{ route('frontend.products') }}"
                    class="flex flex-col items-center gap-2 p-4 bg-gray-50 rounded-[8px] hover:bg-secondary transition text-center group">
                    <div class="w-10 h-10 rounded-[12px] bg-primary/10 flex items-center justify-center text-primary group-hover:bg-white">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Shop Now</span>
                </a>

                <a href="{{ route('client.orders.index') }}"
                    class="flex flex-col items-center gap-2 p-4 bg-gray-50 rounded-[8px] hover:bg-secondary transition text-center group">
                    <div class="w-10 h-10 rounded-[12px] bg-primary/10 flex items-center justify-center text-primary group-hover:bg-white">
                        <i class="fas fa-box"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">My Orders</span>
                </a>

            </div>

        </div>

        {{-- =========================
         RECENT ORDERS + INBOX
    ========================= --}}
        <div class="grid md:grid-cols-2 gap-6">

            {{-- Recent Orders --}}
            <div class="bg-white border border-gray-200 rounded-[8px] p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-gray-900">Recent Orders</h2>
                    <a href="{{ route('client.orders.index') }}" class="text-xs text-primary hover:underline">View All</a>
                </div>
                @forelse ($recentOrders as $order)
                    @php
                        $statusColors = [
                            'pending'    => 'bg-yellow-100 text-yellow-800',
                            'processing' => 'bg-blue-100 text-blue-800',
                            'in_transit' => 'bg-indigo-100 text-indigo-800',
                            'delivered'  => 'bg-green-100 text-green-800',
                            'completed'  => 'bg-emerald-100 text-emerald-800',
                            'cancelled'  => 'bg-red-100 text-red-700',
                            'refunded'   => 'bg-orange-100 text-orange-800',
                        ];
                        $statusCls = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700';
                    @endphp
                    <div class="flex items-center justify-between py-2.5 border-b border-gray-50 last:border-0">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $order->order_code }}</p>
                            <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block text-xs font-semibold px-2 py-0.5 rounded-[12px] {{ $statusCls }}">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                            <p class="text-xs text-gray-500 mt-0.5">KES {{ number_format($order->total, 2) }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-sm text-gray-400 py-6 text-center">
                        <i class="fas fa-box-open text-3xl mb-2 block text-gray-200"></i>
                        No orders yet.
                    </div>
                @endforelse
            </div>

            {{-- Inbox --}}
            <div class="bg-white border border-gray-200 rounded-[8px] p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-gray-900">Inbox</h2>
                    <a href="{{ route('client.inbox.index') }}" class="text-xs text-primary hover:underline">View All</a>
                </div>
                <div class="text-sm text-gray-400 py-6 text-center">
                    <i class="fas fa-envelope-open text-3xl mb-2 block text-gray-200"></i>
                    No messages yet.
                </div>
            </div>

        </div>

        {{-- =========================
         NOTIFICATIONS
    ========================= --}}
        <div class="bg-white border border-gray-200 rounded-[8px] p-6">
            <h2 class="font-bold text-gray-900 mb-4">Notifications</h2>
            <div class="text-sm text-gray-400 py-4 text-center">
                <i class="fas fa-bell text-3xl mb-2 block text-gray-200"></i>
                No new notifications.
            </div>
        </div>

    </div>

@endsection
