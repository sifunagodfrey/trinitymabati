@extends('frontend.layouts.app')

@section('title', 'Checkout - Trinity Mabati Factory')

@section('content')

    <section class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6">

            {{-- Page Heading --}}
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Checkout</h1>
                <p class="text-gray-500 text-sm mt-1">Complete your shipping details to place your order.</p>
            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-[8px] px-5 py-4 text-sm">
                    <p class="font-semibold mb-1">Please fix the following errors:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('frontend.checkout.store') }}" method="POST">
                @csrf

                <div class="grid md:grid-cols-3 gap-8">

                    {{-- LEFT COLUMN – Shipping Details + Items --}}
                    <div class="md:col-span-2 space-y-6">

                        {{-- Shipping Address Card --}}
                        <div class="bg-white border border-gray-200 rounded-[8px] p-6">
                            <h2 class="font-bold text-gray-900 text-lg mb-4">
                                <i class="fas fa-map-marker-alt text-primary mr-2"></i> Shipping Details
                            </h2>

                            <div class="space-y-4">

                                {{-- County --}}
                                <div>
                                    <label for="county_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        County <span class="text-red-500">*</span>
                                    </label>
                                    <select id="county_id" name="county_id" required
                                        class="w-full border border-gray-200 rounded-[8px] px-3 py-2.5 text-sm focus:outline-none focus:border-primary {{ $errors->has('county_id') ? 'border-red-400' : '' }}">
                                        <option value="">Select county...</option>
                                        @foreach ($counties as $county)
                                            <option value="{{ $county->id }}" {{ old('county_id', $prefillCountyId) == $county->id ? 'selected' : '' }}>
                                                {{ $county->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('county_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Delivery Location (dynamic) --}}
                                <div id="location-wrapper" class="hidden">
                                    <label for="location_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        Delivery Location <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <select id="location_id" name="location_id"
                                            class="w-full border border-gray-200 rounded-[8px] px-3 py-2.5 text-sm focus:outline-none focus:border-primary {{ $errors->has('location_id') ? 'border-red-400' : '' }}">
                                            <option value="">Select delivery location...</option>
                                        </select>
                                        <span id="location-loading"
                                            class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">
                                            <i class="fas fa-spinner fa-spin"></i> Loading...
                                        </span>
                                    </div>
                                    @error('location_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror

                                    {{-- Shipping cost + estimated delivery feedback --}}
                                    <div id="shipping-info" class="hidden mt-2 flex items-center gap-3 text-sm">
                                        <span class="flex items-center gap-1 text-gray-700">
                                            <i class="fas fa-truck text-primary text-xs"></i>
                                            Shipping: <strong id="shipping-cost-display" class="text-primary ml-1">-</strong>
                                        </span>
                                        <span id="delivery-time-display" class="text-gray-400"></span>
                                    </div>
                                </div>

                                {{-- No-locations notice: shown when a county has no delivery points --}}
                                <div id="no-locations-notice" class="hidden">
                                    <div class="rounded-[8px] bg-amber-50 border border-amber-200 px-4 py-3 text-sm text-amber-800">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Sorry, we do not deliver to this county yet. Please choose another county or
                                        <a href="{{ route('frontend.contact') }}" class="underline font-medium">contact us</a>.
                                    </div>
                                </div>

                                {{-- Order Notes --}}
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                        Order Notes <span class="text-gray-400 text-xs font-normal">(optional)</span>
                                    </label>
                                    <textarea id="notes" name="notes" rows="3" maxlength="500"
                                        class="w-full border border-gray-200 rounded-[8px] px-3 py-2.5 text-sm focus:outline-none focus:border-primary resize-none"
                                        placeholder="Any special instructions for your order...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Items in Order --}}
                        <div class="bg-white border border-gray-200 rounded-[8px] p-6">
                            <h2 class="font-bold text-gray-900 text-lg mb-4">
                                <i class="fas fa-box text-primary mr-2"></i> Your Items
                            </h2>
                            <div class="space-y-1">
                                @foreach ($items as $item)
                                    <div class="flex items-center gap-4 py-3 border-b border-gray-100 last:border-0">
                                        <div class="w-14 h-14 bg-gray-100 rounded-[8px] overflow-hidden flex-shrink-0">
                                            <img src="{{ asset($item->product->thumbnail ? (str_starts_with($item->product->thumbnail, 'uploads/') ? $item->product->thumbnail : 'uploads/products/images/' . $item->product->thumbnail) : 'images/placeholder.png') }}"
                                                alt="{{ $item->product->name }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-semibold text-gray-900 text-sm">{{ $item->product->name }}</p>
                                            {{-- ---------------
                                            -- Variant: show human-readable attribute values (e.g. Red / EU43)
                                            -- --------------- --}}
                                            @if ($item->variant)
                                                @php
                                                    $variantLabel = $item->variant->variantAttributes
                                                        ->map(fn($va) => optional($va->attributeValue)->value)
                                                        ->filter()->implode(' / ');
                                                @endphp
                                                <p class="text-xs text-gray-400">{{ $variantLabel ?: $item->variant->variant_code }}</p>
                                            @endif
                                            <p class="text-xs text-gray-400">
                                                <i class="fas fa-store mr-1"></i>{{ $item->product->vendor?->store_id ?? 'Trinity Mabati Factory' }}
                                                &nbsp;·&nbsp; Qty: {{ $item->quantity }}
                                            </p>

                                        </div>
                                        <p class="font-bold text-primary text-sm whitespace-nowrap">
                                            @price($item->price_at_time * $item->quantity)
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    {{-- RIGHT COLUMN – Order Summary + Payment Methods (text only) --}}
                    <div class="space-y-4">

                        {{-- Order Summary Card --}}
                        <div class="bg-white border border-gray-200 rounded-[8px] p-6 space-y-4">
                            <h2 class="font-bold text-gray-900 text-lg">Order Summary</h2>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal ({{ $items->count() }} {{ Str::plural('item', $items->count()) }})</span>
                                    <span class="font-semibold">@price($subtotal)</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Shipping</span>
                                    <span id="summary-shipping" class="font-semibold text-gray-400">Select location</span>
                                </div>

                                <div class="border-t border-gray-100 pt-3 flex justify-between text-gray-900 font-bold text-base">
                                    <span>Total</span>
                                    <span id="summary-total" class="text-primary">@price($subtotal)+</span>
                                </div>
                            </div>
                        </div>

                        {{-- Payment Methods Card – Text only (no selection) --}}
                        <div class="bg-white border border-gray-200 rounded-[8px] p-6">
                            <h2 class="font-bold text-gray-900 text-lg mb-3">Accepted Payment Methods</h2>
                            <div class="flex flex-wrap gap-2">
                                @forelse ($paymentMethods as $method)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-700 text-sm rounded-[12px]">
                                        {{ $method->name }}
                                    </span>
                                @empty
                                    <p class="text-sm text-gray-500">No payment methods configured.</p>
                                @endforelse
                            </div>
                            <p class="text-xs text-gray-400 mt-3">You will select a payment method after placing the order.</p>
                        </div>

                        {{-- Place Order Button --}}
                        <button type="submit"
                            class="block w-full text-center px-6 py-3 bg-primary text-white font-bold rounded-[12px] hover:opacity-90 transition">
                            Place Order
                        </button>

                        <a href="{{ route('frontend.cart') }}"
                            class="block w-full text-center px-6 py-3 border border-gray-200 text-gray-600 font-semibold rounded-[12px] hover:border-primary hover:text-primary transition text-sm">
                            Back to Cart
                        </a>

                    </div>

                </div>
            </form>

        </div>
    </section>

    {{-- Shipping + services total calculation script --}}
<script>
    const shippingSettings = @json($shippingSettings);
    const cartDimensions   = @json($cartDimensions);
    const subtotalBase     = {{ (float) $subtotal }};
    const servicesTotal    = 0;

    const totalWeight = cartDimensions.reduce((sum, d) => sum + d.weight, 0);
    const totalVolume = cartDimensions.reduce((sum, d) => sum + d.volume, 0);

    function calcShipping(distanceKm) {
        const s = shippingSettings;
        const weightCharge   = totalWeight > s.weight_threshold
            ? (totalWeight - s.weight_threshold) * s.weight_rate : 0;
        const volumeCharge   = s.volume_divisor > 0
            ? (totalVolume / s.volume_divisor) * s.volume_multiplier : 0;
        const distanceCharge = distanceKm > 10
            ? (distanceKm - 10) * s.distance_rate : 0;

        let shipping = s.base_rate + weightCharge + volumeCharge + distanceCharge;
        if (s.free_shipping_threshold > 0 && subtotalBase >= s.free_shipping_threshold) {
            shipping = 0;
        }
        return Math.round(shipping);
    }

    // ---- Currency ----
    const CURR_RATE   = {{ $currencyRate }};
    const CURR_SYMBOL = '{{ $currencySymbol }}';
    const CURR_CODE   = '{{ $activeCurrency }}';

    // ---------------
    // Saved-address prefill (still fully editable - this only sets the
    // initial selection, same as if the user had picked it themselves)
    // ---------------
    const prefillLocationId = {{ old('location_id') ? (int) old('location_id') : ($prefillLocationId ? (int) $prefillLocationId : 'null') }};
    let prefillApplied = false;

    function fmt(amount) {
        const converted = amount * CURR_RATE;
        const decimals  = CURR_CODE === 'KES' ? 0 : 2;
        return CURR_SYMBOL + ' ' + converted.toLocaleString(undefined, {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals,
        });
    }

    function formatDays(days) {
        if (!days || isNaN(days)) return '';
        const d = Math.floor(days);
        const h = Math.round((days - d) * 24);
        const parts = [];
        if (d) parts.push(d + ' day' + (d !== 1 ? 's' : ''));
        if (h) parts.push(h + ' hr' + (h !== 1 ? 's' : ''));
        return parts.length ? 'Est. delivery: ' + parts.join(' ') : '';
    }

    const countySelect        = document.getElementById('county_id');
    const locationWrapper     = document.getElementById('location-wrapper');
    const noLocationsNotice   = document.getElementById('no-locations-notice');
    const locationSelect      = document.getElementById('location_id');
    const locationLoading     = document.getElementById('location-loading');
    const shippingInfo        = document.getElementById('shipping-info');
    const shippingCostDisplay = document.getElementById('shipping-cost-display');
    const deliveryTimeDisplay = document.getElementById('delivery-time-display');
    const summaryShipping     = document.getElementById('summary-shipping');
    const summaryTotal        = document.getElementById('summary-total');

    countySelect.addEventListener('change', function () {
        const countyId = this.value;
        if (!countyId) {
            locationWrapper.classList.add('hidden');
            noLocationsNotice.classList.add('hidden');
            return;
        }
        locationWrapper.classList.remove('hidden');
        noLocationsNotice.classList.add('hidden');
        shippingInfo.classList.add('hidden');
        locationLoading.classList.remove('hidden');
        locationSelect.innerHTML = '<option value="">Loading locations...</option>';

        fetch(`{{ route('frontend.checkout.locations') }}?county_id=${countyId}`)
            .then(r => r.json())
            .then(locations => {
                locationLoading.classList.add('hidden');
                if (locations.length === 0) {
                    locationWrapper.classList.add('hidden');
                    noLocationsNotice.classList.remove('hidden');
                    locationSelect.innerHTML = '<option value=""></option>';
                    summaryShipping.textContent = 'Unavailable';
                    return;
                }
                locationSelect.innerHTML = '<option value="">Select delivery location...</option>';
                locations.forEach(loc => {
                    const opt        = document.createElement('option');
                    opt.value        = loc.id;
                    opt.textContent  = loc.location_name;
                    opt.dataset.distance = loc.distance || 0;
                    opt.dataset.days     = loc.estimated_delivery || 0;
                    locationSelect.appendChild(opt);
                });

                // ---------------
                // Auto-select the saved delivery location on first load
                // only; still fully editable afterward
                // ---------------
                if (!prefillApplied && prefillLocationId) {
                    const match = Array.from(locationSelect.options)
                        .find(o => parseInt(o.value) === prefillLocationId);
                    if (match) {
                        locationSelect.value = match.value;
                        locationSelect.dispatchEvent(new Event('change'));
                    }
                }
                prefillApplied = true;
            })
            .catch(() => {
                locationLoading.classList.add('hidden');
                locationSelect.innerHTML = '<option value="">Failed to load - please retry</option>';
            });
    });

    locationSelect.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        if (!selected.value) {
            shippingInfo.classList.add('hidden');
            summaryShipping.textContent = 'Select location';
            summaryTotal.textContent    = fmt(subtotalBase + servicesTotal) + '+';
            return;
        }
        const distanceKm = parseFloat(selected.dataset.distance) || 0;
        const days        = parseFloat(selected.dataset.days)     || 0;
        const shipping    = calcShipping(distanceKm);
        const total       = subtotalBase + shipping + servicesTotal;

        shippingCostDisplay.textContent = fmt(shipping);
        deliveryTimeDisplay.textContent = formatDays(days);
        shippingInfo.classList.remove('hidden');

        summaryShipping.textContent = fmt(shipping);
        summaryShipping.classList.remove('text-gray-400');
        summaryShipping.classList.add('text-gray-700');
        summaryTotal.textContent    = fmt(total);
    });

    // ---------------
    // Kick off location loading immediately if a county came prefilled -
    // must come after both addEventListener calls above
    // ---------------
    if (countySelect.value) {
        countySelect.dispatchEvent(new Event('change'));
    }
</script>

@endsection
