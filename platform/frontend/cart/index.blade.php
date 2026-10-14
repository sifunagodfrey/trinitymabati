@extends('frontend.layouts.app')

@section('title', 'My Cart - Trinity Mabati Factory')

@section('content')

    <section class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ---------------
            -- Page Heading
            -- --------------- --}}
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Shopping Cart</h1>
                <p class="text-gray-500 text-sm mt-1">
                    You have <span class="font-semibold text-primary">{{ $items->count() }} {{ Str::plural('item', $items->count()) }}</span> in your cart.
                </p>
            </div>

            @if ($items->isEmpty())

                {{-- ---------------
                -- Empty Cart State
                -- --------------- --}}
                <div class="bg-white border border-gray-200 rounded-[8px] p-12 text-center">
                    <i class="fas fa-shopping-cart text-5xl text-gray-200 mb-4"></i>
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Your cart is empty</h2>
                    <p class="text-gray-400 text-sm mb-6">Browse our products and add items to your cart.</p>
                    <a href="{{ route('frontend.products') }}"
                        class="inline-block px-6 py-3 bg-primary text-white font-bold rounded-[12px] hover:opacity-90 transition">
                        Start Shopping
                    </a>
                </div>

            @else

                {{-- ---------------
                -- Hidden remove forms - placed outside the update form to avoid nested form HTML
                -- --------------- --}}
                @foreach ($items as $item)
                    <form id="remove-form-{{ $item->id }}" action="{{ route('frontend.cart.remove') }}" method="POST" class="hidden">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                    </form>
                @endforeach

                <div class="grid md:grid-cols-3 gap-8">

                    {{-- ---------------
                    -- Cart Items
                    -- --------------- --}}
                    <div class="md:col-span-2">

                        <form action="{{ route('frontend.cart.update') }}" method="POST" id="update-cart-form">
                            @csrf

                            <div class="space-y-4">
                                @foreach ($items as $item)
                                    <div class="bg-white border border-gray-200 rounded-[8px] p-4 flex flex-row gap-4"                                        x-data="{
                                            qty:      {{ $item->quantity }},
                                            _t:       null,
                                            currRate: {{ $currencyRate }},
                                            currSym:  '{{ $currencySymbol }}',
                                            currCode: '{{ $activeCurrency }}'
                                        }"
                                        x-init="
                                            $watch('qty', () => { clearTimeout(_t); _t = setTimeout(() => document.getElementById('update-cart-form').submit(), 700) });
                                        ">

                                        {{-- ---------------
                                        -- Hidden form inputs synced with Alpine
                                        -- --------------- --}}
                                        <input type="hidden" :name="'quantities[{{ $item->id }}]'" :value="qty">

                                        {{-- Product Image --}}
                                        <div class="w-28 h-28 bg-gray-100 rounded-[8px] overflow-hidden flex-shrink-0">                                            <img src="{{ asset($item->product->thumbnail ? (str_starts_with($item->product->thumbnail, 'uploads/') ? $item->product->thumbnail : 'uploads/products/images/' . $item->product->thumbnail) : 'images/placeholder.png') }}"
                                                alt="{{ $item->product->name }}"
                                                class="w-full h-full object-cover">
                                        </div>

                                        {{-- Product Info --}}
                                        <div class="flex-1 flex flex-col justify-between">
                                            <div class="flex items-start justify-between gap-3">
                                                <div>
                                                    <h3 class="font-semibold text-gray-900">{{ $item->product->name }}</h3>
                                                    @if ($item->sheet_length_m ?? null)
                                                        <p class="text-xs text-gray-600">Sheet length: {{ number_format($item->sheet_length_m, 2) }} m</p>
                                                    @endif
                                                    @if ($item->variant)
                                                        <p class="text-xs text-gray-400 mt-0.5">
                                                            <i class="fas fa-tag mr-1"></i> {{ $item->variant->variant_code }}
                                                        </p>
                                                    @endif
                                                    <p class="text-xs text-gray-400 mt-0.5">
                                                        <i class="fas fa-store mr-1"></i> {{ $item->product->vendor?->store?->slug ?? 'Trinity Mabati Factory' }}
                                                    </p>
                                                </div>

                                                {{-- Remove - submits the hidden form above to avoid nested forms --}}
                                                <button type="button"
                                                    onclick="document.getElementById('remove-form-{{ $item->id }}').submit()"
                                                    class="text-gray-300 hover:text-red-500 transition">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>

                                            <div class="flex items-center justify-between mt-3 flex-wrap gap-3">

                                                {{-- ---------------
                                                -- Quantity Stepper
                                                -- --------------- --}}
                                                <div class="flex items-center border border-gray-200 rounded-[8px] overflow-hidden">
                                                    <button type="button"
                                                        @click="qty > 1 && qty--"
                                                        :disabled="qty <= 1"
                                                        :class="qty <= 1 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-gray-100'"
                                                        class="px-3 py-1.5 text-gray-500 transition text-sm">-</button>
                                                    <span class="px-4 py-1.5 text-sm font-semibold border-x border-gray-200" x-text="qty"></span>
                                                    <button type="button"
                                                        @click="qty++"
                                                        class="px-3 py-1.5 text-gray-500 transition text-sm hover:bg-gray-100">+</button>
                                                </div>

                                                {{-- Line Price --}}
                                                <div class="text-right">
                                                    <p class="font-bold text-primary text-lg"
                                                        x-text="currSym + ' ' + (qty * {{ $item->price_at_time }} * currRate).toLocaleString(undefined, { maximumFractionDigits: currCode === 'KES' ? 0 : 2 })"></p>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                @endforeach
                            </div>

                            {{-- Actions --}}
                            <div class="pt-4 mt-2">
                                <a href="{{ route('frontend.products') }}"
                                    class="flex items-center gap-2 text-sm text-gray-500 hover:text-primary transition">
                                    <i class="fas fa-arrow-left text-xs"></i> Continue Shopping
                                </a>
                            </div>

                        </form>

                    </div>

                    {{-- ---------------
                    -- Order Summary
                    -- --------------- --}}
                    <div class="space-y-4">

                        <div class="bg-white border border-gray-200 rounded-[8px] p-6 space-y-4">

                            <h2 class="font-bold text-gray-900 text-lg">Order Summary</h2>

                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal ({{ $items->count() }} {{ Str::plural('item', $items->count()) }})</span>
                                    <span class="font-semibold">@price($subtotal)</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Shipping</span>
                                    <span class="font-semibold text-gray-500">Calculated at checkout</span>
                                </div>

                                <div class="border-t border-gray-100 pt-3 flex justify-between text-gray-900 font-bold text-base">
                                    <span>Estimated Total</span>
                                    <span class="text-primary">@price($subtotal)</span>
                                </div>
                            </div>

                            {{-- Checkout Button --}}
                            <a href="{{ route('frontend.checkout') }}"
                                class="block w-full text-center px-6 py-3 bg-primary text-white font-bold rounded-[12px] hover:opacity-90 transition">
                                Proceed to Checkout
                            </a>

                        </div>
                    </div>

                </div>

            @endif

        </div>
    </section>

@auth
    @if ($items->isNotEmpty())
        {{-- ---------------
        -- Abandoned cart beacon - fires when the user leaves the cart page
        -- without checking out. sendBeacon ensures delivery even on tab/window close.
        -- --------------- --}}
        @push('scripts')
        <script>
            // ---------------
            // Record abandoned cart via beacon on page leave
            // ---------------
            (function () {
                var sent = false;

                function sendAbandonBeacon() {
                    if (sent) return;
                    sent = true;
                    var token = document.querySelector('meta[name="csrf-token"]');
                    if (! token) return;
                    var fd = new FormData();
                    fd.append('_token', token.content);
                    navigator.sendBeacon('{{ route("frontend.cart.abandon") }}', fd);
                }

                document.addEventListener('visibilitychange', function () {
                    if (document.visibilityState === 'hidden') {
                        sendAbandonBeacon();
                    }
                });

                window.addEventListener('beforeunload', function () {
                    sendAbandonBeacon();
                });
            })();
        </script>
        @endpush
    @endif
@endauth

@endsection
