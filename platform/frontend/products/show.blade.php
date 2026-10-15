@extends('frontend.layouts.app')

@section('title', "{$product->name} - Trinity Mabati Factory")
@section('meta_description', $product->short_description ?? $product->name)
@section('og_title', $product->name)
@section('og_description', $product->short_description ?? '')
@section('og_image', $product->thumbnail ? asset(str_starts_with($product->thumbnail, 'uploads/') ? $product->thumbnail : 'uploads/products/images/' . $product->thumbnail) : '')

@section('content')

    {{-- Breadcrumb --}}
    <div class="bg-gray-50 border-b border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2.5 text-xs text-gray-500 flex items-center gap-2 flex-nowrap overflow-x-auto whitespace-nowrap [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
            <a href="{{ route('frontend.home') }}" class="shrink-0 hover:text-primary transition">Home</a>
            <i class="fas fa-chevron-right shrink-0 text-gray-300 text-[10px]"></i>
            <a href="{{ route('frontend.products') }}" class="shrink-0 hover:text-primary transition">Products</a>
            @if ($product->category)
                <i class="fas fa-chevron-right shrink-0 text-gray-300 text-[10px]"></i>
                <a href="{{ route('frontend.categories.show', $product->category->slug) }}" class="shrink-0 hover:text-primary transition">{{ $product->category->name }}</a>
            @endif
            <i class="fas fa-chevron-right shrink-0 text-gray-300 text-[10px]"></i>
            <span class="shrink-0 text-gray-800 font-medium">{{ $product->name }}</span>
        </div>
    </div>

    {{-- Alpine Root with AJAX add-to-cart --}}
    @php
        $minBulkQty = $bulkTiersJson->isNotEmpty() ? $bulkTiersJson->min('min_quantity') : 1;
    @endphp
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6"
        x-data="{
            activeImage: @js($allImages[0]),
            activeTab: 'description',
            qty: {{ $minBulkQty }},
            sheetLengthMode: @js(in_array((string) (float) ($product->default_length_m ?? 1), ['1','2','3'], true) ? (string) (float) ($product->default_length_m ?? 1) : 'custom'),
            customLength: @js(!in_array((string) (float) ($product->default_length_m ?? 1), ['1','2','3'], true) ? (string) ($product->default_length_m ?? 1) : ''),
            get sheetLength() { return this.sheetLengthMode === 'custom' ? Number(this.customLength) : Number(this.sheetLengthMode); },
            get validSheetLength() { return this.sheetLengthMode !== 'custom' || (/^(?:\d+)(?:\.\d{1,2})?$/.test(String(this.customLength)) && Number.isFinite(this.sheetLength) && this.sheetLength >= 0.1 && this.sheetLength <= 30); },
            get lengthMultiplier() { return {{ $product->allow_custom_length ? 'true' : 'false' }} ? (this.validSheetLength ? this.sheetLength : 0) : 1; },
            selectedAttrs: {},
            preferredGauge: @js($product->default_gauge),
            preferredFinish: @js($product->default_finish),
            attributeSlugs: @js(collect($attrGroups)->mapWithKeys(fn($group, $id) => [$id => \Illuminate\Support\Str::slug($group['name'])])->all()),
            selectedVariantId: null,
            variants: @js($variantsJson),
            variantMinPrice: {{ $variantMinPrice ?? 'null' }},
            variantMaxPrice: {{ $variantMaxPrice ?? 'null' }},
            cartItems: @js($cartItems),
            bulkTiers: @js($bulkTiersJson),
            selectedBulkTier: null,
            bulkMinPrice: {{ $bulkMinPrice ?? 'null' }},
            bulkMaxPrice: {{ $bulkMinPrice === null ? 'null' : (float) $bulkTiersJson->max('price_per_unit') }},
            addingToCart: false,
            minBulkQuantity: {{ $minBulkQty }},
            init() {
                if (this.variants.length) {
                    const preferred = this.variants.find(v => {
                        const matches = (slug, desired) => !desired || v.attrs.some(a => String(this.attributeSlugs[String(a.attribute_id)] || '').toLowerCase() === slug && String(a.value).toLowerCase() === String(desired).toLowerCase());
                        return (v.stock_quantity == null || v.stock_quantity === '' || Number(v.stock_quantity) > 0) && matches('gauge', this.preferredGauge) && matches('finish', this.preferredFinish);
                    }) || this.variants.find(v => (v.stock_quantity == null || v.stock_quantity === '' || Number(v.stock_quantity) > 0)) || this.variants[0];
                    if (preferred.attrs && preferred.attrs.length) {
                        preferred.attrs.forEach(a => { this.selectedAttrs[a.attribute_id] = a.value; });
                    } else { this.selectedVariantId = preferred.id; }
                }
            },
            get activeVariant() {
                // ---------------
                // Direct selection - used when no attribute structure exists
                // ---------------
                if (this.selectedVariantId !== null) {
                    return this.variants.find(v => v.id === this.selectedVariantId) ?? null;
                }
                // ---------------
                // Attribute-based selection - used when attrGroups are available (admin-created variants)
                // ---------------
                const keys = Object.keys(this.selectedAttrs);
                if (!keys.length) return null;
                return this.variants.find(v =>
                    keys.every(attrId =>
                        v.attrs.some(a => String(a.attribute_id) === String(attrId) && a.value === this.selectedAttrs[attrId])
                    )
                ) ?? null;
            },
            get showPriceRange() {
                return this.variantMinPrice !== null
                    && this.variantMaxPrice !== null
                    && this.variantMinPrice !== this.variantMaxPrice
                    && !this.activeVariant
                    && Object.keys(this.selectedAttrs).length === 0;
            },
            get unavailableCombination() {
                return {{ $product->is_variant ? 'true' : 'false' }}
                    && Object.keys(this.selectedAttrs).length > 0
                    && !this.activeVariant;
            },
            get showBulkPriceRange() {
                return this.bulkMinPrice !== null
                    && this.bulkMaxPrice !== null
                    && this.bulkMinPrice !== this.bulkMaxPrice
                    && !this.selectedBulkTier
                    && !this.activeVariant
                    && {{ $basePrice == 0 ? 'true' : 'false' }};
            },
            get displayPrice() {
                if (this.selectedBulkTier) return this.selectedBulkTier.price_per_unit * this.lengthMultiplier;
                if (this.activeVariant) {
                    return (this.activeVariant.sale_price ?? this.activeVariant.price) * this.lengthMultiplier;
                }
                // An unmatched gauge/finish is not a sellable variant; never quote the minimum price.
                if ({{ $product->is_variant ? 'true' : 'false' }} && Object.keys(this.selectedAttrs).length) return null;
                if (this.variantMinPrice !== null) return this.variantMinPrice * this.lengthMultiplier;
                // ---------------
                // Bulk-only product: show min tier price when no base price is set
                // ---------------
                if ({{ $basePrice == 0 ? 'true' : 'false' }} && this.bulkMinPrice !== null) return this.bulkMinPrice * this.lengthMultiplier;
                return {{ $basePrice }} * this.lengthMultiplier;
            },
            get displayOriginal() {
                if (this.activeVariant) return this.activeVariant.price * this.lengthMultiplier;
                return {{ $baseOriginal }} * this.lengthMultiplier;
            },
            get displayStock() {
                if (this.activeVariant) return this.activeVariant.stock_quantity;
                return {{ $baseStock === null ? 'null' : (int) $baseStock }};
            },
            get isOnSale() {
                if (this.selectedBulkTier) return false;
                if (this.activeVariant) {
                    return this.activeVariant.sale_price !== null && this.activeVariant.sale_price < this.activeVariant.price;
                }
                return {{ $hasDiscount ? 'true' : 'false' }};
            },
            get isInCart() {
                const productId = {{ $product->id }};
                const variantId = this.activeVariant ? this.activeVariant.id : null;
                return this.cartItems.some(item => 
                    item.product_id == productId && 
                    (item.variant_id == variantId || (item.variant_id === null && variantId === null)) &&
                    (!{{ $product->allow_custom_length ? 'true' : 'false' }} || Number(item.sheet_length_m) === this.sheetLength)
                );
            },
            currencyRate: {{ $currencyRate }},
            currencySymbol: '{{ $currencySymbol }}',
            currencyCode: '{{ $activeCurrency }}',
            fmtPrice(val) {
                const converted = parseFloat(val) * this.currencyRate;
                const decimals = this.currencyCode === 'KES' ? 0 : 2;
                return this.currencySymbol + ' ' + converted.toLocaleString('en-KE', {
                    minimumFractionDigits: decimals,
                    maximumFractionDigits: decimals
                });
            },
            // ---------------
            // Auto-select the bulk tier that matches the current qty
            // ---------------
            autoSelectBulkTier() {
                const n = this.qty;
                const exact = this.bulkTiers.find(t =>
                    n >= t.min_quantity && (t.max_quantity === null || n <= t.max_quantity)
                );
                if (exact) { this.selectedBulkTier = exact; return; }
                // Between tiers - pick the highest whose min is still ≤ n
                const sorted = [...this.bulkTiers].sort((a, b) => b.min_quantity - a.min_quantity);
                this.selectedBulkTier = sorted.find(t => n >= t.min_quantity) ?? null;
            },
            // ---------------
            // Clamp qty to valid bounds and auto-select bulk tier when applicable
            // ---------------
            setQtyFromInput(val) {
                let n = parseInt(val) || 1;
                if (this.bulkTiers.length) {
                    const minQ      = Math.min(...this.bulkTiers.map(t => t.min_quantity));
                    const openEnded = this.bulkTiers.some(t => t.max_quantity === null);
                    const maxQ      = openEnded ? Infinity : Math.max(...this.bulkTiers.map(t => t.max_quantity));
                    n = Math.max(minQ, maxQ === Infinity ? n : Math.min(n, maxQ));
                } else {
                    const maxStock = this.displayStock > 0 ? this.displayStock : 99999;
                    n = Math.max(1, Math.min(n, maxStock));
                }
                this.qty = n;
                if (this.bulkTiers.length) this.autoSelectBulkTier();
            },
            incQty() { this.setQtyFromInput(this.qty + 1); this.syncCartQty(); },
            decQty() { this.setQtyFromInput(this.qty - 1); this.syncCartQty(); },

            // When the item is already in the cart, pushing the stepper
            // updates the cart quantity and totals automatically.
            syncCartTimer: null,
            syncCartQty() {
                if (! this.isInCart || this.unavailableCombination) return;
                clearTimeout(this.syncCartTimer);
                this.syncCartTimer = setTimeout(() => { this.sendCartQuantity(); }, 350);
            },
            async sendCartQuantity() {
                try {
                    const response = await fetch('{{ route('frontend.cart.add') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: {{ $product->id }},
                            variant_id: this.activeVariant ? this.activeVariant.id : null,
                            quantity: this.qty,
                            ...({{ $product->allow_custom_length ? 'true' : 'false' }} ? {sheet_length_m: this.sheetLength} : {}),
                            set_quantity: true
                        })
                    });
                    const data = await response.json();
                    if (data.success) this.updateCartCount(data.count);
                } catch (e) {}
            },
            async addToQuote() {
                if (this.addingToCart || this.unavailableCombination || ({{ $product->allow_custom_length ? 'true' : 'false' }} && !this.validSheetLength) || ({{ $product->is_variant ? 'true' : 'false' }} && !this.activeVariant)) return;
                this.addingToCart = true;
                try {
                    const response = await fetch(@js(route('frontend.quotation.add')), {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content},
                        body: JSON.stringify({product_id: {{ $product->id }}, variant_id: this.activeVariant ? this.activeVariant.id : null, metres: {{ $product->allow_custom_length ? 'true' : 'false' }} ? this.sheetLength : null, quantity: this.qty})
                    });
                    const data = await response.json();
                    if (!response.ok || data.success === false) throw new Error(data.message || Object.values(data.errors || {})[0]?.[0] || 'Could not add to quote');
                    window.location.href = @js(route('frontend.quotation.index'));
                } catch (error) { alert(error.message); } finally { this.addingToCart = false; }
            },
            async addToCart() {
                if (this.addingToCart || this.unavailableCombination || ({{ $product->allow_custom_length ? 'true' : 'false' }} && !this.validSheetLength)) return;
                if ({{ $product->is_variant ? 'true' : 'false' }} && !this.activeVariant) return;

                this.addingToCart = true;
                try {
                    const response = await fetch('{{ route('frontend.cart.add') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: {{ $product->id }},
                            variant_id: this.activeVariant ? this.activeVariant.id : null,
                            quantity: this.qty,
                            ...({{ $product->allow_custom_length ? 'true' : 'false' }} ? {sheet_length_m: this.sheetLength} : {}),
                            ...(this.selectedBulkTier ? {
                                bulk_tier_id: this.selectedBulkTier.id,
                            } : {})
                        })
                    });

                    const data = await response.json();
                    if (data.success) {
                        if (data.analytics && window.trinityTrack) window.trinityTrack('add_to_cart', data.analytics);
                        const newItem = {
                            product_id: {{ $product->id }},
                            variant_id: this.activeVariant ? this.activeVariant.id : null,
                            sheet_length_m: {{ $product->allow_custom_length ? 'true' : 'false' }} ? this.sheetLength : null
                        };
                        if (!this.cartItems.some(item => item.product_id === newItem.product_id && item.variant_id === newItem.variant_id && (!{{ $product->allow_custom_length ? 'true' : 'false' }} || Number(item.sheet_length_m) === this.sheetLength))) {
                            this.cartItems.push(newItem);
                        }
                        this.updateCartCount(data.count);
                    } else {
                        alert(data.message || 'Could not add to cart. Please try again.');
                    }
                } catch (error) {
                    console.error('Add to cart error:', error);
                    alert('An error occurred. Please try again.');
                } finally {
                    this.addingToCart = false;
                }
            },
            updateCartCount(newCount) {
                if (typeof window.updateCartBadges === 'function') {
                    window.updateCartBadges(parseInt(newCount, 10) || 0);
                } else {
                    window.dispatchEvent(new CustomEvent('cart-updated', { detail: { count: newCount } }));
                }
            }
        }">

        {{-- Two-column Hero: Images + Product Info --}}
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_1.15fr] gap-8 mb-10 items-start">

            {{-- LEFT: Image Gallery — sticky, stays in view while info panel scrolls --}}
            <div class="lg:sticky lg:top-28 lg:self-start">
                <div class="flex gap-3">
                    {{-- Vertical thumbnail strip — scrollable up/down, no visible scrollbar --}}
                    @if (count($allImages) > 1)
                        <div class="flex flex-col gap-2 w-16 flex-shrink-0 max-h-[420px] overflow-y-auto scroll-smooth [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
                            @foreach ($allImages as $img)
                                <button @click="activeImage = @js($img)" class="flex-shrink-0 w-16 h-16 rounded-[8px] border-2 overflow-hidden transition-colors duration-150" :class="activeImage === @js($img) ? 'border-secondary' : 'border-border hover:border-secondary/50'">
                                    <img src="{{ $img }}" alt="{{ $product->name }} thumbnail" loading="lazy" decoding="async" width="64" height="64" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif

                    {{-- Main image --}}
                    <div class="relative bg-gray-50 rounded-xl overflow-hidden flex-1 min-w-0 aspect-square">
                        <div class="absolute inset-0 flex items-center justify-center text-gray-300" aria-hidden="true"><i class="fas fa-box-open text-5xl"></i></div>
                        <img src="{{ $allImages[0] }}" fetchpriority="high" decoding="async" :src="activeImage" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-200" onerror="this.style.display='none'" @load="$el.style.display='block'" :key="activeImage">
                        @if ($isFlashSale)
                            <div class="absolute top-3 left-3 bg-red-500 text-white text-[11px] font-extrabold px-3 py-1 rounded-[12px] shadow flex items-center gap-1">
                                <i class="fas fa-bolt"></i> FLASH {{ $flashDiscount }}% OFF
                            </div>
                        @elseif ($hasDiscount)
                            <div class="absolute top-3 right-3 w-11 h-11 rounded-[12px] bg-red-500 text-white flex items-center justify-center text-[10px] font-extrabold shadow leading-tight text-center">
                                -{{ $saleDiscount }}%
                            </div>
                        @endif
                        @if ($product->label && !$isFlashSale)
                            <span class="absolute top-3 left-3 inline-flex items-center text-[10px] font-bold text-white px-2.5 py-0.5 rounded-[12px] shadow" style="background-color: {{ $product->label->color_code ?? '#6b7280' }}">
                                {{ $product->label->name }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- RIGHT: Product Info — separated into cards --}}
            <div class="flex flex-col gap-4">

                {{-- Card: Title + description + badges + rating --}}
                <div class="bg-white border border-border rounded-[8px] p-5">
                    <h1 class="text-lg md:text-xl font-bold text-primary leading-snug">{{ $product->name }}</h1>
                    @if (filled($product->short_description))
                        <p class="mt-2 text-sm leading-relaxed text-gray-600 line-clamp-2">{{ strip_tags($product->short_description) }}</p>
                    @endif

                </div>

                {{-- Card: Flash sale banner (only when active) --}}
                @if ($isFlashSale)
                    <div class="bg-red-50 border border-red-200 rounded-[8px] px-4 py-3 flex items-center gap-3" x-data="{ endsAt: {{ $flashEndsAt }}, t: '00:00:00', tick() { const diff = Math.max(0, Math.floor((this.endsAt - Date.now()) / 1000)); const h = String(Math.floor(diff / 3600)).padStart(2,'0'); const m = String(Math.floor((diff % 3600) / 60)).padStart(2,'0'); const s = String(diff % 60).padStart(2,'0'); this.t = h + ':' + m + ':' + s; } }" x-init="tick(); setInterval(() => tick(), 1000)">
                        <i class="fas fa-bolt text-red-500 text-base flex-shrink-0"></i>
                        <div>
                            <p class="text-[11px] font-bold text-red-600 uppercase tracking-wide">Flash Sale Ends In</p>
                            <p class="text-lg font-extrabold text-red-700 font-mono" x-text="t"></p>
                        </div>
                    </div>
                @endif

                @if ($product->allow_custom_length)
                    <div class="bg-white border border-border rounded-lg p-5">
                        <p class="text-sm font-bold text-gray-900 mb-3">Sheet length (metres)</p>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="option in [{value:'1',label:'1 m'},{value:'2',label:'2 m'},{value:'3',label:'3 m'},{value:'custom',label:'Custom'}]" :key="option.value">
                                <button type="button" @click="sheetLengthMode = option.value" :class="sheetLengthMode === option.value ? 'bg-primary text-white border-primary' : 'bg-white text-gray-800 border-gray-200 hover:border-primary'" class="px-5 py-2 rounded-lg border text-sm font-semibold transition" x-text="option.label"></button>
                            </template>
                        </div>
                        <div x-show="sheetLengthMode === 'custom'" x-cloak class="mt-4">
                            <label for="custom-sheet-length" class="block text-xs font-semibold mb-2">Custom length (metres)</label>
                            <input id="custom-sheet-length" type="text" inputmode="decimal" x-model="customLength" @input="customLength = $event.target.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').slice(0, 7); if (Number(customLength) > 30) customLength = '30'" @blur="if (!validSheetLength) customLength = '0.1'" placeholder="e.g. 2.2" class="w-44 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:ring-primary">
                            <p x-show="!validSheetLength" class="text-xs text-red-600 mt-2">Enter a length from 0.10 to 30 metres (up to two decimal places).</p>
                        </div>
                    </div>
                @endif

                {{-- Card: Price + variant/bulk selectors --}}
                <div class="bg-white border border-border rounded-[8px] p-5">
                    <div class="flex items-start justify-between gap-4 flex-wrap">
                        {{-- Left: price info --}}
                        <div>
                            <div class="flex items-baseline flex-wrap gap-2">
                                <span class="text-2xl md:text-3xl font-extrabold text-secondary" x-text="displayPrice === null ? '—' : fmtPrice(displayPrice)">@price($variantMinPrice ?? ($basePrice > 0 ? $basePrice : ($bulkMinPrice ?? 0)))</span>
                                @if ($product->is_variant && $variantMinPrice !== null && $variantMinPrice != $variantMaxPrice)
                                    <span class="text-xl text-muted font-normal" x-show="showPriceRange"> – </span>
                                    <span class="text-2xl md:text-3xl font-extrabold text-secondary" x-show="showPriceRange" x-text="fmtPrice(variantMaxPrice)">@price($variantMaxPrice)</span>
                                @endif
                                @if ($bulkMinPrice !== null && $basePrice == 0 && $bulkTiersJson->count() > 1)
                                    <span class="text-xl text-muted font-normal" x-show="showBulkPriceRange"> – </span>
                                    <span class="text-2xl md:text-3xl font-extrabold text-secondary" x-show="showBulkPriceRange" x-text="fmtPrice(bulkMaxPrice)">@price($bulkTiersJson->max('price_per_unit'))</span>
                                @endif
                                <span class="text-xs text-muted">per sheet</span>
                                <span class="text-sm text-muted line-through" x-show="(isOnSale || selectedBulkTier) && !showPriceRange && !showBulkPriceRange" x-text="fmtPrice(displayOriginal)"></span>
                                <span class="text-xs font-bold text-red-500 bg-red-50 px-2 py-0.5 rounded" x-show="isOnSale && !selectedBulkTier && !showPriceRange && !showBulkPriceRange">Save {{ $saleDiscount }}%</span>
                                <span class="text-xs font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded flex items-center gap-1" x-show="selectedBulkTier && !showPriceRange"><i class="fas fa-layer-group text-[10px]"></i><span x-text="selectedBulkTier ? 'Bulk: ' + selectedBulkTier.min_quantity + (selectedBulkTier.max_quantity ? '–' + selectedBulkTier.max_quantity : '+') + ' units' : ''"></span></span>
                            </div>
                            <p x-show="unavailableCombination" x-cloak class="mt-2 text-sm font-medium text-red-600" role="status">This gauge and finish combination is not available. Please choose another finish or gauge.</p>
                            @if ($product->is_variant && $variantMinPrice !== null)
                                <p class="text-[11px] mt-0.5 text-muted" x-show="showPriceRange">Select options to see exact price</p>
                            @endif
                            @if ($bulkMinPrice !== null && $basePrice == 0)
                                <p class="text-[11px] mt-0.5 text-blue-600 flex items-center gap-1" x-show="showBulkPriceRange">
                                    <i class="fas fa-layer-group text-[9px]"></i> Select a bulk tier below for the exact unit price
                                </p>
                            @endif
                            <p class="text-[11px] mt-1 {{ $product->is_vat_exempt ? 'text-green-600' : 'text-muted' }}">{{ $product->is_vat_exempt ? 'VAT Exempt' : 'Price includes VAT' }}</p>
                        </div>

                        {{-- Right: quantity stepper --}}
                        <div class="flex-shrink-0">
                            <p class="text-[10px] font-bold uppercase tracking-wide text-muted mb-2 text-right">Quantity</p>
                            <div class="flex items-center border border-border rounded overflow-hidden bg-white">
                                <button @click="decQty" class="w-9 h-9 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition"><i class="fas fa-minus text-xs"></i></button>
                                <input type="number"
                                    :value="qty"
                                    @change="setQtyFromInput($event.target.value)"
                                    @keydown.enter.prevent="setQtyFromInput($event.target.value); $event.target.blur()"
                                    min="1"
                                    class="w-14 text-center text-sm font-bold text-text bg-transparent outline-none border-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                <button @click="incQty" class="w-9 h-9 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition"><i class="fas fa-plus text-xs"></i></button>
                            </div>
                            @if ($bulkTiersJson->isNotEmpty())
                                <template x-if="minBulkQuantity > displayStock && displayStock > 0">
                                    <p class="text-[10px] text-red-500 mt-1.5 max-w-[160px] text-right">
                                        <i class="fas fa-exclamation-triangle"></i> Min {{ $minBulkQty }} exceeds stock ({{ $baseStock }})
                                    </p>
                                </template>
                            @endif
                        </div>
                    </div>

                    @if ($bulkTiersJson->isNotEmpty())
                        <div class="mt-3">
                            <p class="text-[11px] text-blue-600 flex items-center gap-1 mb-2 font-semibold"><i class="fas fa-layer-group text-[10px]"></i> Bulk pricing - select a tier:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($bulkTiersJson as $tier)
                                    <button type="button"
                                        @click="selectedBulkTier = (selectedBulkTier && selectedBulkTier.id === {{ $tier['id'] }}) ? null : @js($tier); qty = selectedBulkTier ? selectedBulkTier.min_quantity : {{ $minBulkQty }}"
                                        :class="selectedBulkTier && selectedBulkTier.id === {{ $tier['id'] }} ? 'bg-primary text-white border-primary' : 'border-border text-gray-600 hover:border-primary hover:text-primary bg-white'"
                                        class="text-[11px] px-3 py-1.5 rounded border transition font-medium whitespace-nowrap">
                                        {{ $tier['min_quantity'] }}{{ $tier['max_quantity'] ? '–' . $tier['max_quantity'] : '+' }} units · @price($tier['price_per_unit'])/unit{{ $tier['label'] ? ' (' . $tier['label'] . ')' : '' }}
                                    </button>
                                @endforeach
                            </div>
                            <p x-show="selectedBulkTier" class="text-[11px] mt-1.5 text-blue-700 font-medium flex items-center gap-1">
                                <i class="fas fa-check-circle"></i> Tier applied - <button type="button" @click="selectedBulkTier = null; qty = minBulkQuantity" class="underline hover:no-underline">clear</button>
                            </p>
                        </div>
                    @endif

                    @if ($product->is_variant && count($attrGroups))
                        @foreach ($attrGroups as $attrId => $attr)
                            <div class="mt-4">
                                <p class="text-xs font-bold text-text mb-2 uppercase tracking-wide">
                                    {{ $attr['name'] }}:
                                    <span class="font-normal text-secondary normal-case tracking-normal"
                                        x-text="selectedAttrs['{{ $attrId }}'] ?? ''"></span>
                                </p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($attr['values'] as $val)
                                        <button
                                            @click="selectedAttrs['{{ $attrId }}'] = @js($val); if (activeVariant && activeVariant.image) activeImage = activeVariant.image"
                                            class="text-xs px-3.5 py-1.5 rounded border transition font-medium"
                                            :class="selectedAttrs['{{ $attrId }}'] === @js($val) ? 'bg-primary text-white border-primary' : 'border-border text-gray-600 hover:border-primary hover:text-primary bg-white'">
                                            {{ $val }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @elseif ($product->is_variant && $product->variants->isNotEmpty())
                        <div class="mt-4">
                            <p class="text-xs font-bold text-text mb-2 uppercase tracking-wide">
                                Variant:
                                <span class="font-normal text-secondary normal-case tracking-normal"
                                    x-text="activeVariant ? activeVariant.variant_code : ''"></span>
                            </p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($product->variants as $variant)
                                    <button
                                        @click="selectedVariantId = {{ $variant->id }}; const v = variants.find(x => x.id === {{ $variant->id }}); if (v && v.image) activeImage = v.image;"
                                        class="text-xs px-3.5 py-1.5 rounded border transition font-medium"
                                        :class="activeVariant && activeVariant.id === {{ $variant->id }} ? 'bg-primary text-white border-primary' : 'border-border text-gray-600 hover:border-primary hover:text-primary bg-white'">
                                        {{ $variant->variant_code }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Shopping cart and quotation are separate baskets. --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <template x-if="!isInCart">
                        <button type="button" @click="addToCart()"
                            :disabled="addingToCart || unavailableCombination || ({{ $product->allow_custom_length ? 'true' : 'false' }} && !validSheetLength) || ({{ $product->is_variant ? 'true' : 'false' }} && !activeVariant)"
                            class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-4 py-3.5 text-sm font-bold text-white transition hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-50">
                            <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                            <span x-text="addingToCart ? 'Adding...' : 'Add to Cart'"></span>
                        </button>
                    </template>
                    <template x-if="isInCart">
                        <a href="{{ route('frontend.cart') }}"
                            class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-4 py-3.5 text-sm font-bold text-white transition hover:opacity-90">
                            <i class="fas fa-shopping-cart" aria-hidden="true"></i> View Cart
                        </a>
                    </template>
                    <button type="button" @click="addToQuote()"
                        :disabled="addingToCart || unavailableCombination || ({{ $product->allow_custom_length ? 'true' : 'false' }} && !validSheetLength) || ({{ $product->is_variant ? 'true' : 'false' }} && !activeVariant)"
                        class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg border-2 border-primary px-4 py-3.5 text-sm font-bold text-primary transition hover:bg-primary/10 disabled:cursor-not-allowed disabled:opacity-50">
                        <i class="fas fa-file-invoice" aria-hidden="true"></i> Get a Quote
                    </button>
                </div>

                {{-- Share --}}
                <div class="flex items-center gap-4">
                    <button class="flex items-center gap-1.5 text-xs text-muted hover:text-secondary transition"><i class="fas fa-share-alt"></i> Share</button>
                </div>
            </div>
        </div>

        {{-- Tabs Section --}}
        <div id="product-tabs" class="bg-white border border-border rounded-[12px] overflow-hidden">
            <div class="flex overflow-x-auto border-b border-border">
                <button @click="activeTab = 'description'" class="flex-shrink-0 px-5 py-3.5 text-xs font-semibold transition border-b-2" :class="activeTab === 'description' ? 'border-primary text-primary' : 'border-transparent text-muted hover:text-text'">Description</button>
                <button @click="activeTab = 'benefits'" class="flex-shrink-0 px-5 py-3.5 text-xs font-semibold transition border-b-2" :class="activeTab === 'benefits' ? 'border-primary text-primary' : 'border-transparent text-muted hover:text-text'">Features &amp; Benefits</button>
            </div>
            <div class="p-6">
                {{-- Tab: Description --}}
                <div x-show="activeTab === 'description'" x-transition>
                    @if ($product->detailed_description)
                        <div class="text-sm text-gray-700 leading-relaxed [&_p]:mb-3 [&_p:last-child]:mb-0 [&_h1]:text-xl [&_h1]:font-bold [&_h1]:text-gray-900 [&_h1]:mt-4 [&_h1]:mb-2 [&_h2]:text-lg [&_h2]:font-bold [&_h2]:text-gray-900 [&_h2]:mt-4 [&_h2]:mb-2 [&_h3]:text-base [&_h3]:font-semibold [&_h3]:text-gray-900 [&_h3]:mt-3 [&_h3]:mb-1 [&_ul]:list-disc [&_ul]:pl-5 [&_ul]:mb-3 [&_ul]:space-y-1 [&_ol]:list-decimal [&_ol]:pl-5 [&_ol]:mb-3 [&_ol]:space-y-1 [&_li]:text-sm [&_strong]:font-semibold [&_b]:font-semibold [&_em]:italic [&_i]:italic [&_a]:text-primary [&_a]:underline [&_a:hover]:opacity-80 [&_blockquote]:border-l-4 [&_blockquote]:border-gray-200 [&_blockquote]:pl-4 [&_blockquote]:italic [&_blockquote]:text-gray-500 [&_blockquote]:my-3 [&_hr]:my-4 [&_hr]:border-gray-200">
                            {!! $product->detailed_description !!}
                        </div>
                    @elseif ($product->short_description)
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $product->short_description }}</p>
                    @else
                        <p class="text-sm text-muted italic">No description available for this product.</p>
                    @endif
                </div>

                <div x-show="activeTab === 'benefits'" x-transition>
                    <div class="text-sm text-gray-700 leading-relaxed">
                        <p>Contact Trinity Mabati Factory for this product's features and benefits.</p>
                    </div>
                </div>

            </div>
        </div>

        <style>
            .trinity-related-rail { display: flex; align-items: flex-start; gap: 12px; overflow-x: auto; padding-bottom: 16px; scroll-snap-type: x mandatory; scroll-behavior: smooth; scrollbar-width: none; }
            .trinity-related-rail::-webkit-scrollbar { display: none; }
            .trinity-related-card { display: flex; flex-direction: column; flex: 0 0 calc((100% - 24px) / 2.1); min-width: 0; scroll-snap-align: start; }
            @media (min-width: 640px) { .trinity-related-rail { gap: 16px; align-items: stretch; } .trinity-related-card { flex-basis: calc((100% - 32px) / 3); } }
            @media (min-width: 1024px) { .trinity-related-card { flex-basis: calc((100% - 48px) / 4); } }
        </style>

        {{-- Related Products --}}
        @if ($relatedProductsWithMeta->isNotEmpty())
            <div class="mt-10">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg md:text-xl font-bold text-text">{{ $relatedSectionTitle ?? 'You may also like' }}</h2>
                    <a href="{{ route('frontend.products') }}" class="text-xs font-semibold text-primary hover:underline">View more →</a>
                </div>
                <div class="relative group" x-data="{
                    scrollLeft() { this.$refs.relatedRail.scrollBy({ left: -300, behavior: 'smooth' }) },
                    scrollRight() { this.$refs.relatedRail.scrollBy({ left: 300, behavior: 'smooth' }) }
                }">
                    <button @click="scrollLeft()" type="button" aria-label="Scroll left"
                        class="absolute left-0 top-1/2 z-10 hidden h-8 w-8 -translate-y-1/2 items-center justify-center rounded-[12px] bg-white text-primary opacity-0 shadow-md ring-1 ring-border transition hover:text-secondary group-hover:flex group-hover:opacity-100">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                    <div x-ref="relatedRail" class="trinity-related-rail" tabindex="0" aria-label="Related products, scroll horizontally">
                        @foreach ($relatedProductsWithMeta as $related)
                            <div class="trinity-related-card">@include('frontend.partials.product-card', ['product' => $related])</div>
                        @endforeach
                    </div>
                    <button @click="scrollRight()" type="button" aria-label="Scroll right"
                        class="absolute right-0 top-1/2 z-10 hidden h-8 w-8 -translate-y-1/2 items-center justify-center rounded-[12px] bg-white text-primary opacity-0 shadow-md ring-1 ring-border transition hover:text-secondary group-hover:flex group-hover:opacity-100">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>
@endsection