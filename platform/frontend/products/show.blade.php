@extends('frontend.layouts.app')

@section('title', "{$product->name} - Trinity Mabati Factory")
@section('meta_description', $product->short_description ?? $product->name)
@section('og_title', $product->name)
@section('og_description', $product->short_description ?? '')
@section('og_image', $product->thumbnail ? asset(str_starts_with($product->thumbnail, 'uploads/') ? $product->thumbnail : 'uploads/products/images/' . $product->thumbnail) : '')

@section('content')

    {{-- Breadcrumb --}}
    <div class="bg-gray-50 border-b border-border">
        <div class="max-w-7xl mx-auto px-4 py-2.5 text-xs text-gray-500 flex items-center gap-2 flex-wrap">
            <a href="{{ route('frontend.home') }}" class="hover:text-primary transition">Home</a>
            <i class="fas fa-chevron-right text-gray-300 text-[10px]"></i>
            <a href="{{ route('frontend.products') }}" class="hover:text-primary transition">Products</a>
            @if ($product->category)
                <i class="fas fa-chevron-right text-gray-300 text-[10px]"></i>
                <a href="{{ route('frontend.products', ['category_id' => $product->category_id]) }}" class="hover:text-primary transition">{{ $product->category->name }}</a>
            @endif
            <i class="fas fa-chevron-right text-gray-300 text-[10px]"></i>
            <span class="text-gray-800 font-medium truncate max-w-[200px]">{{ $product->name }}</span>
        </div>
    </div>

    {{-- Alpine Root with AJAX add-to-cart --}}
    @php
        $minBulkQty = $bulkTiersJson->isNotEmpty() ? $bulkTiersJson->min('min_quantity') : 1;
    @endphp
    <div class="max-w-7xl mx-auto px-4 py-6"
        x-data="{
            activeImage: @js($allImages[0]),
            activeTab: 'description',
            qty: {{ $minBulkQty }},
            selectedAttrs: {},
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
                if (this.selectedBulkTier) return this.selectedBulkTier.price_per_unit;
                if (this.activeVariant) {
                    return this.activeVariant.sale_price ?? this.activeVariant.price;
                }
                if (this.variantMinPrice !== null) return this.variantMinPrice;
                // ---------------
                // Bulk-only product: show min tier price when no base price is set
                // ---------------
                if ({{ $basePrice == 0 ? 'true' : 'false' }} && this.bulkMinPrice !== null) return this.bulkMinPrice;
                return {{ $basePrice }};
            },
            get displayOriginal() {
                if (this.activeVariant) return this.activeVariant.price;
                return {{ $baseOriginal }};
            },
            get displayStock() {
                if (this.activeVariant) return this.activeVariant.stock_quantity;
                return {{ $baseStock }};
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
                    (item.variant_id == variantId || (item.variant_id === null && variantId === null))
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
                if (! this.isInCart) return;
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
                            set_quantity: true
                        })
                    });
                    const data = await response.json();
                    if (data.success) this.updateCartCount(data.count);
                } catch (e) {}
            },
            async addToCart() {
                if (this.addingToCart) return;
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
                            ...(this.selectedBulkTier ? {
                                bulk_tier_id: this.selectedBulkTier.id,
                            } : {})
                        })
                    });

                    const data = await response.json();
                    if (data.success) {
                        const newItem = {
                            product_id: {{ $product->id }},
                            variant_id: this.activeVariant ? this.activeVariant.id : null
                        };
                        if (!this.cartItems.some(item => item.product_id === newItem.product_id && item.variant_id === newItem.variant_id)) {
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
                                    <img src="{{ $img }}" alt="Product thumbnail" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif

                    {{-- Main image --}}
                    <div class="relative bg-gray-50 border border-border rounded-[8px] overflow-hidden flex-1" style="aspect-ratio: 1 / 1;">
                        <img :src="activeImage" alt="{{ $product->name }}" class="w-full h-full object-contain p-4 transition-opacity duration-200">
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
                    <h1 class="text-lg md:text-xl font-bold text-secondary leading-snug">{{ $product->name }}</h1>

                    @if ($product->short_description)
                        <p class="text-xs text-muted leading-relaxed mt-1.5">{{ $product->short_description }}</p>
                    @endif

                    <div class="flex items-center flex-wrap gap-2 mt-3">
                        @if ($product->brand)
                            <span class="text-[10px] font-bold uppercase tracking-wide text-gray-600 bg-gray-100 px-2.5 py-1 rounded">{{ $product->brand->name }}</span>
                        @endif
                        @foreach ($product->categories as $cat)
                            <span class="text-[10px] font-bold uppercase tracking-wide text-gray-600 bg-gray-100 px-2.5 py-1 rounded">{{ $cat->name }}</span>
                        @endforeach
                        @foreach ($product->labels as $lbl)
                            <span class="text-[10px] font-bold uppercase tracking-wide text-gray-600 bg-gray-100 px-2.5 py-1 rounded">{{ $lbl->name }}</span>
                        @endforeach
                        @if ($product->condition)
                            <span class="text-[10px] font-bold uppercase tracking-wide text-gray-600 bg-gray-100 px-2.5 py-1 rounded">{{ ucfirst($product->condition) }}</span>
                        @endif
                        <span class="text-[10px] font-bold uppercase tracking-wide px-2.5 py-1 rounded"
                            :class="(displayStock > 0 || (bulkTiers.length > 0 && !activeVariant)) ? 'text-green-700 bg-green-100' : 'text-red-600 bg-red-100'"
                            x-text="(displayStock > 0 || (bulkTiers.length > 0 && !activeVariant)) ? 'In Stock' : 'Out of Stock'">
                            {{ $baseStock > 0 ? 'In Stock' : ($product->is_bulk_enabled && $bulkTiersJson->isNotEmpty() ? 'In Stock' : 'Out of Stock') }}
                        </span>
                    </div>

                    <div class="flex items-center flex-wrap gap-4 text-xs text-muted mt-3">
                        <div class="flex items-center gap-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-xs {{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-200' }}"></i>
                            @endfor
                            <span class="ml-1 text-gray-600 font-medium">{{ number_format($avgRating, 1) }}</span>
                            <button @click="activeTab = 'reviews'" class="ml-1 hover:text-secondary transition">({{ $reviewCount }} {{ Str::plural('review', $reviewCount) }})</button>
                        </div>
                    </div>
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

                {{-- Card: Price + variant/bulk selectors --}}
                <div class="bg-white border border-border rounded-[8px] p-5">
                    <div class="flex items-start justify-between gap-4 flex-wrap">
                        {{-- Left: price info --}}
                        <div>
                            <div class="flex items-baseline flex-wrap gap-2">
                                <span class="text-2xl md:text-3xl font-extrabold text-secondary" x-text="fmtPrice(displayPrice)">@price($variantMinPrice ?? ($basePrice > 0 ? $basePrice : ($bulkMinPrice ?? 0)))</span>
                                @if ($product->is_variant && $variantMinPrice !== null && $variantMinPrice != $variantMaxPrice)
                                    <span class="text-xl text-muted font-normal" x-show="showPriceRange"> – </span>
                                    <span class="text-2xl md:text-3xl font-extrabold text-secondary" x-show="showPriceRange" x-text="fmtPrice(variantMaxPrice)">@price($variantMaxPrice)</span>
                                @endif
                                @if ($bulkMinPrice !== null && $basePrice == 0 && $bulkTiersJson->count() > 1)
                                    <span class="text-xl text-muted font-normal" x-show="showBulkPriceRange"> – </span>
                                    <span class="text-2xl md:text-3xl font-extrabold text-secondary" x-show="showBulkPriceRange" x-text="fmtPrice(bulkMaxPrice)">@price($bulkTiersJson->max('price_per_unit'))</span>
                                @endif
                                <span class="text-xs text-muted">per unit</span>
                                <span class="text-sm text-muted line-through" x-show="(isOnSale || selectedBulkTier) && !showPriceRange && !showBulkPriceRange" x-text="fmtPrice(displayOriginal)"></span>
                                <span class="text-xs font-bold text-red-500 bg-red-50 px-2 py-0.5 rounded" x-show="isOnSale && !selectedBulkTier && !showPriceRange && !showBulkPriceRange">Save {{ $saleDiscount }}%</span>
                                <span class="text-xs font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded flex items-center gap-1" x-show="selectedBulkTier && !showPriceRange"><i class="fas fa-layer-group text-[10px]"></i><span x-text="selectedBulkTier ? 'Bulk: ' + selectedBulkTier.min_quantity + (selectedBulkTier.max_quantity ? '–' + selectedBulkTier.max_quantity : '+') + ' units' : ''"></span></span>
                            </div>
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
                                        :class="selectedBulkTier && selectedBulkTier.id === {{ $tier['id'] }} ? 'bg-blue-600 text-white border-blue-600' : 'border-border text-gray-600 hover:border-blue-500 hover:text-blue-600 bg-white'"
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
                                            :class="selectedAttrs['{{ $attrId }}'] === @js($val) ? 'bg-secondary text-white border-secondary' : 'border-border text-gray-600 hover:border-secondary hover:text-secondary bg-white'">
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
                                        :class="activeVariant && activeVariant.id === {{ $variant->id }} ? 'bg-secondary text-white border-secondary' : 'border-border text-gray-600 hover:border-secondary hover:text-secondary bg-white'">
                                        {{ $variant->variant_code }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Card: Line total --}}
                <div class="bg-white border border-border rounded-[8px] p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-wide text-muted">Line Total</p>
                            <p class="text-[11px] text-muted" x-text="qty + ' pc' + (qty > 1 ? 's' : '')"></p>
                        </div>
                        <p class="text-lg font-extrabold text-secondary" x-text="fmtPrice(displayPrice * qty)"></p>
                    </div>
                </div>

                {{-- Actions: Add to Cart + Order on WhatsApp --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <template x-if="!isInCart">
                        <button type="button"
                            @click="addToCart"
                            :disabled="addingToCart || ({{ $product->is_variant ? 'true' : 'false' }} && !activeVariant)"
                            :class="({{ $product->is_variant ? 'true' : 'false' }} && !activeVariant) || addingToCart ? 'opacity-50 cursor-not-allowed' : 'hover:opacity-90'"
                            class="flex-1 flex items-center justify-center gap-2 bg-secondary text-white font-bold text-sm rounded-[8px] py-3.5 transition shadow-sm">
                            <i class="fas fa-cart-plus" x-show="!addingToCart"></i>
                            <i class="fas fa-spinner fa-spin" x-show="addingToCart"></i>
                            <span x-text="addingToCart ? 'Adding...' : 'Add to Cart'"></span>
                        </button>
                    </template>
                    <template x-if="isInCart">
                        <a href="{{ route('frontend.cart') }}"
                           class="flex-1 flex items-center justify-center gap-2 bg-secondary text-white font-bold text-sm rounded-[8px] py-3.5 transition shadow-sm hover:opacity-90">
                            <i class="fas fa-shopping-cart"></i> View Cart
                        </a>
                    </template>

                    <a :href="`https://wa.me/{{ $whatsappNumber ?? '' }}?text=` + encodeURIComponent(
                            `Hi, I'd like to order:\n\n*{{ $product->name }}*\nQuantity: ${qty}\nPrice: ${fmtPrice(displayPrice)} each\nTotal: ${fmtPrice(displayPrice * qty)}\n\nLink: {{ $pUrl ?? url()->current() }}`
                        )"
                       target="_blank" rel="noopener"
                       class="flex-1 flex items-center justify-center gap-2 border-2 border-green-500 text-green-600 font-bold text-sm rounded-[8px] py-3 transition hover:bg-green-500 hover:text-white">
                        <i class="fab fa-whatsapp text-base"></i> Order on WhatsApp
                    </a>
                </div>

                {{-- Wishlist + Share --}}
                <div class="flex items-center gap-4">
                    <button x-data="{ inWishlist: {{ $inWishlist ? 'true' : 'false' }}, loading: false, async toggle() { if (this.loading) return; this.loading = true; try { const r = await fetch('{{ route('client.wishlist.toggle', $product->id) }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json', 'Content-Type': 'application/json' } }); if (r.status === 401) { window.location.href = '{{ route('login') }}'; return; } const d = await r.json(); this.inWishlist = d.status === 'added'; } finally { this.loading = false; } } }" @click="toggle()" :disabled="loading" :class="inWishlist ? 'text-red-500' : 'text-muted hover:text-red-500'" class="flex items-center gap-1.5 text-xs transition"><i :class="inWishlist ? 'fas fa-heart' : 'far fa-heart'"></i><span x-text="inWishlist ? 'Saved to Wishlist' : 'Add to Wishlist'"></span></button>
                    <span class="text-border text-xs">|</span>
                    <button class="flex items-center gap-1.5 text-xs text-muted hover:text-secondary transition"><i class="fas fa-share-alt"></i> Share</button>
                </div>
            </div>
        </div>

        {{-- Tabs Section --}}
        <div id="product-tabs" class="bg-white border border-border rounded-[12px] overflow-hidden">
            <div class="flex overflow-x-auto border-b border-border">
                <button @click="activeTab = 'description'" class="flex-shrink-0 px-5 py-3.5 text-xs font-semibold transition border-b-2" :class="activeTab === 'description' ? 'border-primary text-primary' : 'border-transparent text-muted hover:text-text'">Description</button>
                <button @click="activeTab = 'specs'" class="flex-shrink-0 px-5 py-3.5 text-xs font-semibold transition border-b-2" :class="activeTab === 'specs' ? 'border-primary text-primary' : 'border-transparent text-muted hover:text-text'">Specifications</button>
                <button @click="activeTab = 'reviews'" class="flex-shrink-0 px-5 py-3.5 text-xs font-semibold transition border-b-2" :class="activeTab === 'reviews' ? 'border-primary text-primary' : 'border-transparent text-muted hover:text-text'">Reviews @if ($reviewCount > 0)<span class="ml-1 bg-primary text-white text-[10px] px-1.5 py-0.5 rounded-[12px]">{{ $reviewCount }}</span>@endif</button>
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

                {{-- Tab: Specifications --}}
                <div x-show="activeTab === 'specs'" x-transition>
                    @php
                        $specs = array_filter([
                            'SKU' => $product->sku,
                            'Condition' => $product->condition ? ucfirst($product->condition) : null,
                            'Brand' => $product->brand?->name,
                            'Category' => $product->category?->name,
                            'Weight' => $product->weight ? "{$product->weight} kg" : null,
                            'Length' => $product->length ? "{$product->length} cm" : null,
                            'Width' => $product->width ? "{$product->width} cm" : null,
                            'Height' => $product->height ? "{$product->height} cm" : null,
                            'Currency' => $product->currency,
                            'VAT' => $product->is_vat_exempt ? 'Exempt' : 'Applicable',
                        ]);
                    @endphp
                    @if (count($specs))
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            @foreach ($specs as $label => $value)
                                <div class="flex items-center justify-between bg-gray-50 rounded-[8px] px-4 py-2.5">
                                    <span class="text-xs text-muted font-medium">{{ $label }}</span>
                                    <span class="text-xs text-text font-semibold">{{ $value }}</span>
                                </div>
                            @endforeach
                            @if ($product->condition_notes)
                                <div class="sm:col-span-2 bg-gray-50 rounded-[8px] px-4 py-2.5">
                                    <p class="text-xs text-muted font-medium mb-1">Condition Notes</p>
                                    <p class="text-xs text-text">{{ $product->condition_notes }}</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-sm text-muted italic">No specifications available.</p>
                    @endif
                </div>

                {{-- Tab: Reviews --}}
                <div x-show="activeTab === 'reviews'" x-transition id="reviews">
                    <div class="flex flex-col sm:flex-row items-start gap-6 mb-6">
                        <div class="flex flex-col items-center justify-center bg-gray-50 rounded-[12px] px-8 py-5 flex-shrink-0">
                            <p class="text-4xl font-extrabold text-text">{{ number_format($avgRating, 1) }}</p>
                            <div class="flex items-center gap-0.5 mt-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-sm {{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-200' }}"></i>
                                @endfor
                            </div>
                            <p class="text-xs text-muted mt-1">{{ $reviewCount }} {{ Str::plural('review', $reviewCount) }}</p>
                        </div>
                        <div class="flex-1 space-y-2 w-full pt-1">
                            @for ($star = 5; $star >= 1; $star--)
                                @php
                                    $starCount = $approvedReviews->where('rating', $star)->count();
                                    $pct = $reviewCount ? round($starCount / $reviewCount * 100) : 0;
                                @endphp
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-muted w-10 flex-shrink-0">{{ $star }} <i class="fas fa-star text-yellow-400 text-[10px]"></i></span>
                                    <div class="flex-1 bg-gray-100 rounded-[12px] h-2 overflow-hidden">
                                        <div class="bg-yellow-400 h-2 rounded-[12px] transition-all" style="width: {{ $pct }}%"></div>
                                    </div>
                                    <span class="text-xs text-muted w-6 text-right flex-shrink-0">{{ $starCount }}</span>
                                </div>
                            @endfor
                        </div>
                    </div>
                    @forelse ($approvedReviews->take(8) as $review)
                        <div class="border-t border-border py-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-[12px] bg-primary/10 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-user text-primary text-xs"></i>
                                    </div>
                                    <span class="text-xs font-semibold text-text">{{ $review->user->first_name ?? 'Customer' }}</span>
                                    <span class="text-[10px] text-muted">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex items-center gap-0.5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-[10px] {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed pl-10">{{ $review->comment }}</p>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <i class="fas fa-comment-alt text-4xl text-gray-200 mb-3"></i>
                            <p class="text-sm text-muted">No reviews yet for this product.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>

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
                    <div x-ref="relatedRail" class="hm-rail">
                        @foreach ($relatedProductsWithMeta as $related)
                            <div class="hm-card">@include('frontend.partials.product-card', ['product' => $related])</div>
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