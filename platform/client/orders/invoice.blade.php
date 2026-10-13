{{-- ---------------
-- Client Order Invoice (Print View)
-- --------------- --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $order->order_code }} | Haromi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.branding')
    <style>
        /* ---------------
         * Print Overrides
         * --------------- */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
                padding: 0 !important;
            }

            .invoice-card {
                box-shadow: none !important;
                border-radius: 0 !important;
            }
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen py-10">

    {{-- ---------------
    -- Toolbar (hidden on print)
    -- --------------- --}}
    <div class="max-w-2xl mx-auto mb-4 flex items-center justify-between no-print px-2">
        <a href="{{ route('client.orders.show', $order->id) }}"
            class="inline-flex items-center gap-1.5 text-sm text-gray-600 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left text-xs"></i>
            Back to Order
        </a>
        <button onclick="window.print()"
            class="inline-flex items-center gap-2 px-5 py-2 text-sm font-semibold bg-gray-900 text-white rounded-[12px] hover:bg-gray-700 transition">
            <i class="fas fa-print text-xs"></i>
            Print / Save as PDF
        </button>
    </div>

    {{-- ---------------
    -- Invoice Card
    -- --------------- --}}
    <div class="invoice-card max-w-2xl mx-auto bg-white shadow-md rounded-[12px] overflow-hidden">

        {{-- ---------------
        -- Invoice Header
        -- --------------- --}}
        <div class="bg-gray-900 text-white px-8 py-6">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-extrabold tracking-tight">HAROMI</h1>
                    <p class="text-gray-400 text-xs mt-0.5">Stationery &amp; Office Supplies</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400 uppercase tracking-widest mb-0.5">Invoice</p>
                    <p class="text-lg font-bold">#{{ $order->order_code }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $order->created_at->format('F d, Y') }}</p>
                </div>
            </div>
        </div>

        <div class="px-8 py-6 space-y-6">

            {{-- ---------------
            -- Billed To / Delivery
            -- --------------- --}}
            <div class="grid grid-cols-2 gap-8">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Billed To</p>
                    <p class="font-semibold text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</p>
                    <p class="text-sm text-gray-500 mt-0.5">{{ $user->email }}</p>
                    @if ($user->phone)
                        <p class="text-sm text-gray-500">{{ $user->phone }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Delivery</p>
                    <p class="text-sm text-gray-700 font-medium">{{ $county->name ?? '-' }}</p>
                    <p class="text-sm text-gray-500">{{ $location->name ?? '-' }}</p>
                </div>
            </div>

            {{-- ---------------
            -- Order & Payment Status
            -- --------------- --}}
            @php
                $statusColors = [
                    'completed'  => 'bg-green-100 text-green-700',
                    'processing' => 'bg-blue-100 text-blue-700',
                    'pending'    => 'bg-amber-100 text-amber-700',
                    'in_transit' => 'bg-sky-100 text-sky-700',
                    'cancelled'  => 'bg-red-100 text-red-700',
                    'refunded'   => 'bg-gray-100 text-gray-600',
                ];
                $paymentColors = [
                    'paid'       => 'bg-green-100 text-green-700',
                    'processing' => 'bg-blue-100 text-blue-700',
                    'failed'     => 'bg-red-100 text-red-700',
                    'refunded'   => 'bg-gray-100 text-gray-600',
                    'pending'    => 'bg-amber-100 text-amber-700',
                ];
            @endphp
            <div class="flex gap-2 flex-wrap">
                <span
                    class="px-3 py-1 rounded-[12px] text-xs font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-600' }}">
                    Order: {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                </span>
                <span
                    class="px-3 py-1 rounded-[12px] text-xs font-semibold {{ $paymentColors[$order->payment_status] ?? 'bg-gray-100 text-gray-600' }}">
                    Payment: {{ ucfirst($order->payment_status) }}
                </span>
            </div>

            {{-- ---------------
            -- Items Table
            -- --------------- --}}
            <div class="border border-gray-200 rounded-[8px] overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="text-left px-4 py-3 font-semibold text-gray-600">Product</th>
                            <th class="text-center px-3 py-3 font-semibold text-gray-600">Qty</th>
                            <th class="text-right px-3 py-3 font-semibold text-gray-600">Unit</th>
                            <th class="text-right px-4 py-3 font-semibold text-gray-600">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
                                    @if ($item->variant_label)
                                        <p class="text-xs text-gray-400">{{ $item->variant_label }}</p>
                                    @endif
                                </td>
                                <td class="px-3 py-3 text-center text-gray-700">{{ $item->quantity }}</td>
                                <td class="px-3 py-3 text-right text-gray-700">
                                    KES {{ number_format($item->price, 2) }}
                                </td>
                                <td class="px-4 py-3 text-right font-semibold text-gray-900">
                                    KES {{ number_format($item->price * $item->quantity, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ---------------
            -- Totals
            -- --------------- --}}
            @php
                $subtotal = $order->items->sum(fn($item) => $item->price * $item->quantity);
            @endphp
            <div class="max-w-xs ml-auto space-y-1.5 text-sm">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal</span>
                    <span>KES {{ number_format($subtotal, 2) }}</span>
                </div>
                @if (($order->shipping_cost ?? 0) > 0)
                    <div class="flex justify-between text-gray-600">
                        <span>Shipping</span>
                        <span>KES {{ number_format($order->shipping_cost, 2) }}</span>
                    </div>
                @endif
                @if (($order->tax ?? 0) > 0)
                    <div class="flex justify-between text-gray-600">
                        <span>Tax (VAT)</span>
                        <span>KES {{ number_format($order->tax, 2) }}</span>
                    </div>
                @endif
                @if (($order->discount ?? 0) > 0)
                    <div class="flex justify-between text-green-600">
                        <span>Discount</span>
                        <span>− KES {{ number_format($order->discount, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between font-bold text-gray-900 text-base border-t border-gray-200 pt-2 mt-1">
                    <span>Total</span>
                    <span>KES {{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            {{-- ---------------
            -- Footer Note
            -- --------------- --}}
            <div class="border-t border-gray-100 pt-5 text-center">
                <p class="text-xs text-gray-400">
                    Thank you for shopping with {{ config('app.name') }}. For support, please
                    <a href="{{ route('frontend.contact') }}" class="underline hover:text-gray-600 no-print">
                        contact us
                    </a>.
                </p>
                <p class="text-xs text-gray-300 mt-1">
                    Generated {{ $order->created_at->format('F d, Y') }}
                </p>
            </div>

        </div>

    </div>

</body>

</html>
