{{-- ---------------
-- Client Orders Index
-- --------------- --}}
@extends('client.layouts.app')

@section('title', 'My Orders | Haromi')

@section('content')

    {{-- ---------------
    -- Page Header
    -- --------------- --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-900">My Orders</h2>
            <p class="text-sm text-gray-500 mt-0.5">
                {{ $orders->total() }} {{ Str::plural('order', $orders->total()) }} placed
            </p>
        </div>
        <a href="{{ route('frontend.products') }}"
            class="text-sm font-medium text-primary hover:underline flex items-center gap-1.5">
            <i class="fas fa-shopping-cart text-xs"></i>
            Shop More
        </a>
    </div>

    {{-- ---------------
    -- Flash Messages
    -- --------------- --}}
    @if (session('success'))
        <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-[8px] px-4 py-3">
            <i class="fas fa-check-circle text-green-500"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- ---------------
    -- Orders List
    -- --------------- --}}
    @if ($orders->isNotEmpty())

        @php
            $statusConfig = [
                'completed'  => ['bg-green-100 text-green-700', 'Completed'],
                'processing' => ['bg-blue-100 text-blue-700', 'Processing'],
                'pending'    => ['bg-amber-100 text-amber-700', 'Pending'],
                'in_transit' => ['bg-sky-100 text-sky-700', 'In Transit'],
                'cancelled'  => ['bg-red-100 text-red-700', 'Cancelled'],
                'refunded'   => ['bg-gray-100 text-gray-600', 'Refunded'],
            ];
            $paymentConfig = [
                'paid'       => ['bg-green-100 text-green-700', 'Paid'],
                'processing' => ['bg-blue-100 text-blue-700', 'Processing'],
                'failed'     => ['bg-red-100 text-red-700', 'Failed'],
                'refunded'   => ['bg-gray-100 text-gray-600', 'Refunded'],
                'pending'    => ['bg-amber-100 text-amber-700', 'Pending'],
            ];
        @endphp

        {{-- Desktop Table --}}
        <div class="hidden md:block bg-white border border-gray-200 rounded-[8px] overflow-hidden shadow-sm">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600">Order</th>
                        <th class="text-left px-4 py-3.5 font-semibold text-gray-600">Date</th>
                        <th class="text-left px-4 py-3.5 font-semibold text-gray-600">Items</th>
                        <th class="text-left px-4 py-3.5 font-semibold text-gray-600">Total</th>
                        <th class="text-left px-4 py-3.5 font-semibold text-gray-600">Status</th>
                        <th class="text-left px-4 py-3.5 font-semibold text-gray-600">Payment</th>
                        <th class="px-4 py-3.5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($orders as $order)
                        @php
                            [$statusClass, $statusLabel] = $statusConfig[$order->status] ?? ['bg-gray-100 text-gray-600', ucfirst($order->status)];
                            [$paymentClass, $paymentLabel] = $paymentConfig[$order->payment_status] ?? ['bg-gray-100 text-gray-600', ucfirst($order->payment_status)];
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-4">
                                <a href="{{ route('client.orders.show', $order->id) }}"
                                    class="font-semibold text-gray-900 hover:text-primary transition">
                                    #{{ $order->order_code }}
                                </a>
                            </td>
                            <td class="px-4 py-4 text-gray-500">
                                {{ $order->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-4 text-gray-500">
                                {{ $order->items_count }} {{ Str::plural('item', $order->items_count) }}
                            </td>
                            <td class="px-4 py-4 font-medium text-gray-900">
                                KES {{ number_format($order->total, 2) }}
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-[12px] text-xs font-semibold {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-[12px] text-xs font-semibold {{ $paymentClass }}">
                                    {{ $paymentLabel }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-right">
                                <a href="{{ route('client.orders.show', $order->id) }}"
                                    class="text-xs font-medium text-primary hover:underline">
                                    View →
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="md:hidden space-y-3">
            @foreach ($orders as $order)
                @php
                    [$statusClass, $statusLabel] = $statusConfig[$order->status] ?? ['bg-gray-100 text-gray-600', ucfirst($order->status)];
                    [$paymentClass, $paymentLabel] = $paymentConfig[$order->payment_status] ?? ['bg-gray-100 text-gray-600', ucfirst($order->payment_status)];
                @endphp
                <a href="{{ route('client.orders.show', $order->id) }}"
                    class="block bg-white border border-gray-200 rounded-[8px] p-4 shadow-sm hover:shadow-md transition">
                    <div class="flex items-start justify-between mb-2">
                        <span class="font-semibold text-gray-900 text-sm">#{{ $order->order_code }}</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-[12px] text-xs font-semibold {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                        <span>{{ $order->created_at->format('M d, Y') }}</span>
                        <span>{{ $order->items_count }} {{ Str::plural('item', $order->items_count) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-gray-900 text-sm">KES {{ number_format($order->total, 2) }}</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-[12px] text-xs font-semibold {{ $paymentClass }}">
                            {{ $paymentLabel }}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- ---------------
        -- Pagination
        -- --------------- --}}
        @if ($orders->hasPages())
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif

    @else

        {{-- ---------------
        -- Empty State
        -- --------------- --}}
        <div class="text-center py-20">
            <div class="w-20 h-20 rounded-[12px] bg-gray-100 flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-shopping-bag text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">No orders yet</h3>
            <p class="text-sm text-gray-500 mb-6 max-w-sm mx-auto">
                You haven't placed any orders yet. Start shopping to see your order history here.
            </p>
            <a href="{{ route('frontend.products') }}"
                class="inline-block px-6 py-3 bg-primary text-white rounded-[12px] text-sm font-semibold hover:opacity-90 transition">
                Browse Products
            </a>
        </div>

    @endif

@endsection
