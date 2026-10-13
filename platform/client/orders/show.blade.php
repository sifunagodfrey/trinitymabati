{{-- ---------------
-- Client Order Detail
-- --------------- --}}
@extends('client.layouts.app')

@section('title', 'Order #' . $order->order_code . ' | Haromi')

@section('content')

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
        [$statusClass, $statusLabel] = $statusConfig[$order->status] ?? ['bg-gray-100 text-gray-600', ucfirst($order->status)];
        [$paymentClass, $paymentLabel] = $paymentConfig[$order->payment_status] ?? ['bg-gray-100 text-gray-600', ucfirst($order->payment_status)];
        $canCancel = in_array($order->status, ['pending', 'processing']);
    @endphp

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-[8px] px-4 py-3">
            <i class="fas fa-check-circle text-green-500"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-5 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 text-sm rounded-[8px] px-4 py-3">
            <i class="fas fa-exclamation-circle text-red-500"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- Order Header --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-6">
        <div>
            <div class="flex items-center gap-2 flex-wrap">
                <h2 class="text-lg font-bold text-gray-900">Order #{{ $order->order_code }}</h2>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-[12px] text-xs font-semibold {{ $statusClass }}">
                    {{ $statusLabel }}
                </span>
            </div>
            <p class="text-sm text-gray-500 mt-0.5">
                Placed on {{ $order->created_at->format('F d, Y \a\t g:i A') }}
            </p>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('client.orders.invoice', $order->id) }}"
                target="_blank"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold bg-gray-100 text-gray-700 rounded-[12px] hover:bg-gray-200 transition">
                <i class="fas fa-file-invoice text-xs"></i>
                Invoice
            </a>
            @if ($canCancel)
                <button onclick="document.getElementById('cancel-modal').classList.remove('hidden')"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold bg-red-50 text-red-600 rounded-[12px] hover:bg-red-100 transition">
                    <i class="fas fa-times text-xs"></i>
                    Cancel Order
                </button>
            @endif
        </div>
    </div>

    {{-- Status Overview Cards --}}
    <div class="grid grid-cols-3 gap-3 mb-5">
        <div class="bg-white border border-gray-200 rounded-[8px] p-4">
            <p class="text-xs text-gray-400 mb-1.5">Order Status</p>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-[12px] text-xs font-semibold {{ $statusClass }}">
                {{ $statusLabel }}
            </span>
        </div>
        <div class="bg-white border border-gray-200 rounded-[8px] p-4">
            <p class="text-xs text-gray-400 mb-1.5">Payment</p>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-[12px] text-xs font-semibold {{ $paymentClass }}">
                {{ $paymentLabel }}
            </span>
        </div>
        <div class="bg-white border border-gray-200 rounded-[8px] p-4">
            <p class="text-xs text-gray-400 mb-1.5">Order Total</p>
            <p class="font-bold text-gray-900 text-sm">KES {{ number_format($order->total, 2) }}</p>
        </div>
    </div>

    {{-- Delivery Information --}}
    <div class="bg-white border border-gray-200 rounded-[8px] p-5 mb-4">
        <h3 class="font-semibold text-gray-900 text-sm mb-3 flex items-center gap-2">
            <i class="fas fa-map-marker-alt text-primary text-xs"></i>
            Delivery Information
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
            <div>
                <p class="text-gray-400 text-xs mb-0.5">County</p>
                <p class="text-gray-900 font-medium">{{ $county->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs mb-0.5">Location</p>
                <p class="text-gray-900 font-medium">{{ $location->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-400 text-xs mb-0.5">Shipping Cost</p>
                <p class="text-gray-900 font-medium">KES {{ number_format($order->shipping_cost ?? 0, 2) }}</p>
            </div>
            @if ($order->expected_delivery)
                <div>
                    <p class="text-gray-400 text-xs mb-0.5">Expected Delivery</p>
                    <p class="text-gray-900 font-medium">
                        {{ \Carbon\Carbon::parse($order->expected_delivery)->format('M d, Y') }}
                    </p>
                </div>
            @endif
            @if ($order->notes)
                <div class="col-span-2">
                    <p class="text-gray-400 text-xs mb-0.5">Notes</p>
                    <p class="text-gray-700">{{ $order->notes }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Order Timeline --}}
    <div class="bg-white border border-gray-200 rounded-[8px] p-5 mb-4">
        <h3 class="font-semibold text-gray-900 text-sm mb-4 flex items-center gap-2">
            <i class="fas fa-route text-primary text-xs"></i>
            Order Timeline
        </h3>

        @if ($history->isEmpty())
            <p class="text-sm text-gray-400">No updates have been recorded for this order yet.</p>
        @else
            <ol class="relative border-l border-gray-200 ml-2 space-y-5">
                @foreach ($history as $event)
                    <li class="ml-5">
                        <span class="absolute -left-[7px] mt-1 flex h-3.5 w-3.5 items-center justify-center rounded-[12px]
                            {{ $loop->first ? 'bg-primary ring-4 ring-primary-light' : 'bg-gray-300' }}"></span>
                        <p class="text-sm font-medium text-gray-900">
                            @php
                                $label = str_contains($event->status, ':')
                                    ? trim(str_replace(['payment_status:', 'status:'], ['Payment ', ''], $event->status))
                                    : $event->status;
                            @endphp
                            {{ ucwords(str_replace(['_', '-'], ' ', $label)) }}
                        </p>
                        @if ($event->note)
                            <p class="text-sm text-gray-500">{{ $event->note }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ \Carbon\Carbon::parse($event->created_at)->format('M d, Y H:i') }}
                        </p>
                    </li>
                @endforeach
            </ol>
        @endif
    </div>

    {{-- Order Items Table --}}
    <div class="bg-white border border-gray-200 rounded-[8px] overflow-hidden mb-4">

        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900 text-sm">
                Order Items ({{ $order->items->count() }})
            </h3>
        </div>

        {{-- Desktop --}}
        <div class="hidden md:block">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left px-5 py-3 font-semibold text-gray-600">Product</th>
                        <th class="text-center px-4 py-3 font-semibold text-gray-600">Qty</th>
                        <th class="text-right px-4 py-3 font-semibold text-gray-600">Unit Price</th>
                        <th class="text-right px-5 py-3 font-semibold text-gray-600">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($order->items as $item)
                        <tr>
                            <td class="px-5 py-4">
                                <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
                                @if ($item->variant_label)
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $item->variant_label }}</p>
                                @endif
                                @if ($order->status === 'completed' && $item->product)
                                    @php
                                        $userReview = $item->product->reviews->where('user_id', Auth::id())->first();
                                    @endphp
                                    <div class="mt-2">
                                        @if ($userReview)
                                            <div class="flex items-center gap-2">
                                                <div class="flex text-amber-400 text-xs">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star{{ $i <= $userReview->rating ? '' : '-o' }}"></i>
                                                    @endfor
                                                </div>
                                                <span class="text-xs text-gray-500">Your review: {{ $userReview->comment ?: 'No comment' }}</span>
                                                @if ($userReview->status === 'pending')
                                                    <span class="text-xs text-amber-600">(pending approval)</span>
                                                @endif
                                            </div>
                                        @else
                                            <button type="button"
                                                onclick="document.getElementById('review-modal-{{ $item->product_id }}').classList.remove('hidden')"
                                                class="text-xs text-primary hover:underline flex items-center gap-1 mt-1">
                                                <i class="fas fa-star"></i> Write a review
                                            </button>
                                        @endif
                                    </div>
                                @endif
                                @if ($order->status === 'completed' && !$item->product)
                                    <div class="mt-2 text-xs text-gray-400 italic">Product no longer available for review</div>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-center text-gray-700">{{ $item->quantity }}</td>
                            <td class="px-4 py-4 text-right text-gray-700">KES {{ number_format($item->price, 2) }}</td>
                            <td class="px-5 py-4 text-right font-semibold text-gray-900">
                                KES {{ number_format($item->price * $item->quantity, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile --}}
        <div class="md:hidden divide-y divide-gray-100">
            @foreach ($order->items as $item)
                <div class="px-5 py-4 flex flex-col gap-2">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">{{ $item->product_name }}</p>
                            @if ($item->variant_label)
                                <p class="text-xs text-gray-400">{{ $item->variant_label }}</p>
                            @endif
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $item->quantity }} × KES {{ number_format($item->price, 2) }}
                            </p>
                        </div>
                        <p class="text-sm font-semibold text-gray-900 flex-shrink-0">
                            KES {{ number_format($item->price * $item->quantity, 2) }}
                        </p>
                    </div>
                    @if ($order->status === 'completed' && $item->product)
                        @php
                            $userReview = $item->product->reviews->where('user_id', Auth::id())->first();
                        @endphp
                        <div class="mt-1">
                            @if ($userReview)
                                <div class="flex items-center gap-2 flex-wrap">
                                    <div class="flex text-amber-400 text-xs">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $userReview->rating ? '' : '-o' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-gray-500">Your review: {{ $userReview->comment ?: 'No comment' }}</span>
                                    @if ($userReview->status === 'pending')
                                        <span class="text-xs text-amber-600">(pending approval)</span>
                                    @endif
                                </div>
                            @else
                                <button type="button"
                                    onclick="document.getElementById('review-modal-{{ $item->product_id }}').classList.remove('hidden')"
                                    class="text-xs text-primary hover:underline flex items-center gap-1">
                                    <i class="fas fa-star"></i> Write a review
                                </button>
                            @endif
                        </div>
                    @endif
                    @if ($order->status === 'completed' && !$item->product)
                        <div class="mt-1 text-xs text-gray-400 italic">Product no longer available for review</div>
                    @endif
                </div>
            @endforeach
        </div>

    </div>

    {{-- Order Totals --}}
    <div class="bg-white border border-gray-200 rounded-[8px] p-5 mb-6">
        @php
            $subtotal = $order->items->sum(fn($item) => $item->price * $item->quantity);
        @endphp
        <div class="max-w-xs ml-auto space-y-2 text-sm">
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
            <div class="flex justify-between font-bold text-gray-900 text-base border-t border-gray-100 pt-2 mt-1">
                <span>Total</span>
                <span>KES {{ number_format($order->total, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Bottom Navigation --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('client.orders.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-900 transition">
            <i class="fas fa-arrow-left text-xs"></i>
            Back to Orders
        </a>
        <a href="{{ route('client.orders.invoice', $order->id) }}"
            target="_blank"
            class="inline-flex items-center gap-1.5 text-sm font-medium text-primary hover:underline">
            <i class="fas fa-print text-xs"></i>
            Print Invoice
        </a>
    </div>

    {{-- Cancel Confirmation Modal --}}
    @if ($canCancel)
        <div id="cancel-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black/50"
                onclick="document.getElementById('cancel-modal').classList.add('hidden')"></div>
            <div class="relative bg-white rounded-[12px] shadow-xl max-w-sm w-full p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Cancel this order?</h3>
                <p class="text-sm text-gray-500 mb-5">
                    This action cannot be undone. Order
                    <strong>#{{ $order->order_code }}</strong> will be marked as cancelled.
                </p>
                <div class="flex gap-3">
                    <button onclick="document.getElementById('cancel-modal').classList.add('hidden')"
                        class="flex-1 py-2.5 text-sm font-semibold border border-gray-200 rounded-[8px] hover:bg-gray-50 transition">
                        Keep Order
                    </button>
                    <form method="POST" action="{{ route('client.orders.cancel', $order->id) }}" class="flex-1">
                        @csrf
                        <button type="submit"
                            class="w-full py-2.5 text-sm font-semibold bg-red-600 text-white rounded-[8px] hover:bg-red-700 transition">
                            Yes, Cancel
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Review Modals (only for completed orders and where product exists) --}}
    @if ($order->status === 'completed')
        @foreach ($order->items as $item)
            @if ($item->product)
                @php
                    $existingReview = $item->product->reviews->where('user_id', Auth::id())->first();
                @endphp
                @if (!$existingReview)
                    <div id="review-modal-{{ $item->product_id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
                        <div class="absolute inset-0 bg-black/50" onclick="document.getElementById('review-modal-{{ $item->product_id }}').classList.add('hidden')"></div>
                        <div class="relative bg-white rounded-[12px] shadow-xl max-w-md w-full p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Review Product</h3>
                            <p class="text-sm text-gray-500 mb-4">Share your experience with <strong>{{ $item->product_name }}</strong></p>

                            <form method="POST" action="{{ route('client.review.store') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                <input type="hidden" name="order_id" value="{{ $order->id }}">

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Rating *</label>
                                    <div class="flex gap-2 text-2xl text-amber-400" id="rating-stars-{{ $item->product_id }}">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="far fa-star cursor-pointer hover:text-amber-500 transition" data-rating="{{ $i }}"></i>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="rating-input-{{ $item->product_id }}" required>
                                </div>

                                <div class="mb-5">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Comment (optional)</label>
                                    <textarea name="comment" rows="3" class="w-full border border-gray-200 rounded-[8px] px-3 py-2 text-sm focus:outline-none focus:border-primary resize-none" placeholder="What did you like or dislike?"></textarea>
                                </div>

                                <div class="flex gap-3">
                                    <button type="button" onclick="document.getElementById('review-modal-{{ $item->product_id }}').classList.add('hidden')"
                                        class="flex-1 py-2.5 text-sm font-semibold border border-gray-200 rounded-[8px] hover:bg-gray-50 transition">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="flex-1 py-2.5 text-sm font-semibold bg-primary text-white rounded-[8px] hover:opacity-90 transition">
                                        Submit Review
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @push('scripts')
                    <script>
                        (function() {
                            const stars = document.querySelectorAll('#rating-stars-{{ $item->product_id }} i');
                            const ratingInput = document.getElementById('rating-input-{{ $item->product_id }}');
                            if (stars.length && ratingInput) {
                                stars.forEach(star => {
                                    star.addEventListener('click', function() {
                                        const rating = this.getAttribute('data-rating');
                                        ratingInput.value = rating;
                                        stars.forEach(s => {
                                            const starRating = s.getAttribute('data-rating');
                                            if (starRating <= rating) {
                                                s.className = 'fas fa-star text-amber-400';
                                            } else {
                                                s.className = 'far fa-star';
                                            }
                                        });
                                    });
                                });
                            }
                        })();
                    </script>
                    @endpush
                @endif
            @endif
        @endforeach
    @endif

@endsection