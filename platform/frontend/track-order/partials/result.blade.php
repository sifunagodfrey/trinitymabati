{{-- -------------------
     Track Order Result
     The not-found notice or the order card + timeline. Shared by the
     full page and the AJAX lookup so they never drift apart.
------------------- --}}

@if ($searched && ! $order)
    <div class="rounded-[12px] bg-amber-50 border border-amber-200 px-5 py-4 text-sm text-amber-800 flex items-start gap-3">
        <i class="fas fa-circle-exclamation mt-0.5"></i>
        <div>
            <p class="font-semibold">We could not find that order.</p>
            <p class="mt-0.5">Please check that the order number and email match what you used at checkout. If you still need help, <a href="{{ route('frontend.contact') }}" class="underline font-medium">contact us</a>.</p>
        </div>
    </div>
@endif

@if ($order)
    @php
        $statusStyles = [
            'pending'    => ['Pending', 'bg-amber-100 text-amber-800'],
            'processing' => ['Processing', 'bg-blue-100 text-blue-800'],
            'in_transit' => ['In Transit', 'bg-indigo-100 text-indigo-800'],
            'delivered'  => ['Delivered', 'bg-emerald-100 text-emerald-800'],
            'completed'  => ['Completed', 'bg-emerald-100 text-emerald-800'],
            'cancelled'  => ['Cancelled', 'bg-red-100 text-red-700'],
            'refunded'   => ['Refunded', 'bg-gray-200 text-gray-700'],
        ];
        $payStyles = [
            'pending'    => ['Pending', 'bg-amber-100 text-amber-800'],
            'paid'       => ['Paid', 'bg-emerald-100 text-emerald-800'],
            'processing' => ['Processing', 'bg-blue-100 text-blue-800'],
            'failed'     => ['Failed', 'bg-red-100 text-red-700'],
            'refunded'   => ['Refunded', 'bg-gray-200 text-gray-700'],
        ];
        $st  = $statusStyles[$order->status] ?? [ucfirst($order->status), 'bg-gray-100 text-gray-700'];
        $pst = $payStyles[$order->payment_status] ?? [ucfirst($order->payment_status), 'bg-gray-100 text-gray-700'];
    @endphp

    <div class="bg-white border border-border rounded-[12px] p-5 md:p-6 shadow-sm text-left">

        {{-- Header --}}
        <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-border">
            <div>
                <p class="text-xs text-muted">Order Number</p>
                <p class="text-base font-bold text-text">{{ $order->order_code }}</p>
                <p class="text-xs text-muted mt-0.5">Placed {{ \Illuminate\Support\Carbon::parse($order->created_at)->format('d M Y, g:i A') }}</p>
            </div>
            <div class="flex flex-col items-end gap-1.5">
                <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold {{ $st[1] }}">{{ $st[0] }}</span>
                <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold {{ $pst[1] }}">Payment: {{ $pst[0] }}</span>
            </div>
        </div>

        {{-- Items --}}
        <div class="py-4 border-b border-border">
            <p class="text-xs font-bold text-text uppercase tracking-wide mb-3">Items</p>
            <ul class="space-y-2.5">
                @foreach ($order->items as $item)
                    <li class="flex items-center justify-between gap-3 text-sm">
                        <span class="text-text">
                            {{ $item->product_name }}
                            @if ($item->variant_label)
                                <span class="text-muted text-xs">({{ $item->variant_label }})</span>
                            @endif
                            <span class="text-muted text-xs">x {{ $item->quantity }}</span>
                        </span>
                        <span class="font-semibold text-text whitespace-nowrap">KSh {{ number_format($item->price * $item->quantity) }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Total --}}
        <div class="py-4 border-b border-border flex items-center justify-between">
            <span class="text-sm font-semibold text-text">Order Total</span>
            <span class="text-base font-bold text-primary">KSh {{ number_format($order->total) }}</span>
        </div>

        {{-- Timeline --}}
        <div class="pt-4">
            <p class="text-xs font-bold text-text uppercase tracking-wide mb-4">Progress</p>

            @if ($timeline->isEmpty())
                <p class="text-sm text-muted">No status updates yet. We will update this as your order moves along.</p>
            @else
                <ol class="relative border-l-2 border-gray-100 ml-2 space-y-5">
                    @foreach ($timeline as $entry)
                        <li class="ml-5">
                            <span class="absolute -left-[7px] w-3 h-3 rounded-[12px] bg-primary border-2 border-white"></span>
                            <p class="text-sm font-semibold text-text">{{ $entry->note ?: \Illuminate\Support\Str::headline(str_replace(['status:', 'payment_status:', 'shipping_status:'], '', $entry->status)) }}</p>
                            <p class="text-xs text-muted mt-0.5">{{ \Illuminate\Support\Carbon::parse($entry->created_at)->format('d M Y, g:i A') }}</p>
                        </li>
                    @endforeach
                </ol>
            @endif
        </div>

    </div>
@endif
