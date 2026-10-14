{{-- -------------------
     Product Card (shared)
     Used by homepage rails, category pages, search and related items.
     The whole card links to the product detail page; buying actions
     live on that page, not here.

     Usage: @include('frontend.partials.product-card', ['product' => $product])
     Accepts an Eloquent Product model (variants relation recommended)
     or a normalized array with at least: id, slug, name.
------------------- --}}
@php
    if (is_array($product)) {
        $pId = $product['id'] ?? null;
        $pSlug = $product['slug'] ?? '';
        $pName = $product['name'] ?? '';
        $pThumb = $product['thumbnail'] ?? null;
        $pCategory = $product['category_name'] ?? ($product['category'] ?? null);
        $pIsVariant = (bool) ($product['is_variant'] ?? false);
        $pSelling = isset($product['selling']) ? (float) $product['selling'] : null;
        $pStrike = isset($product['strike']) && $product['strike'] ? (float) $product['strike'] : null;
        $pInStock = $product['in_stock'] ?? true;
        $pMinSell = $pSelling;
        $pMaxSell = $pSelling;
    } else {
        $pId = $product->id;
        $pSlug = $product->slug;
        $pName = $product->name;
        $pThumb = $product->thumbnail;
        $pCategory = $product->relationLoaded('category') ? $product->category?->name : null;
        $pIsVariant =
            (bool) $product->is_variant && $product->relationLoaded('variants') && $product->variants->isNotEmpty();

        if ($pIsVariant) {
            $sellPrices = $product->variants->map(fn($v) => (float) ($v->sale_price ?? $v->price));
            $pMinSell = $sellPrices->min();
            $pMaxSell = $sellPrices->max();
            $pSelling = $pMinSell;
            $pStrike = null;
            $pInStock = $product->variants->sum('stock_quantity') > 0;
        } else {
            $pSelling = (float) ($product->sale_price ?? ($product->price ?? 0));
            $pStrike = $product->sale_price && $product->price > $product->sale_price ? (float) $product->price : null;
            $pMinSell = $pSelling;
            $pMaxSell = $pSelling;
            $pInStock = ($product->stock_quantity ?? 0) > 0;
        }
    }

    if (!is_array($product) && $product->allow_custom_length) {
        $metres = (float) ($product->default_length_m ?? 3);
        $pSelling *= $metres;
        $pMinSell *= $metres;
        $pMaxSell *= $metres;
        if ($pStrike !== null) $pStrike *= $metres;
    }

    $pDiscount =
        $pStrike && $pSelling && $pStrike > $pSelling ? round((($pStrike - $pSelling) / $pStrike) * 100) : null;

    $pImage = $pThumb
        ? asset(
            str_starts_with($pThumb, 'uploads/') || str_starts_with($pThumb, 'storage/')
                ? $pThumb
                : 'uploads/products/images/' . $pThumb,
        )
        : null;

    $pUrl = route('frontend.products.show', $pSlug);
@endphp

<a href="{{ $pUrl }}"
    class="group flex h-full flex-col bg-white border border-border overflow-hidden rounded-lg 
          hover:shadow-md hover:border-primary/40 transition-all duration-300 relative">

    {{-- Badges: flat rectangles, top-left, stacked --}}
    <div class="absolute top-0 left-0 z-10 flex flex-col items-start">
        @if ($pDiscount)
            <span class="bg-secondary text-white text-[10px] font-bold uppercase tracking-wide px-3 py-1.5"
                style="font-family: var(--font-ui);">
                Save {{ $pDiscount }}%
            </span>
        @endif
        @if (!$pInStock)
            <span class="bg-text text-white text-[10px] font-bold uppercase tracking-wide px-3 py-1.5"
                style="font-family: var(--font-ui);">
                Sold Out
            </span>
        @endif
    </div>

    {{-- Image: flat, no rounding, light gray backdrop --}}
    <span class="relative block bg-background w-full overflow-hidden" style="aspect-ratio: 1 / 1;">
        @if ($pImage)
            <img src="{{ $pImage }}" alt="{{ $pName }}" loading="lazy"
                class="absolute inset-0 w-full h-full object-contain group-hover:scale-105 transition-transform duration-500">
        @else
            <span class="absolute inset-0 flex items-center justify-center">
                <i class="fas fa-box-open text-4xl text-primary/20"></i>
            </span>
        @endif
    </span>

    {{-- Info --}}
    <span class="flex min-h-[112px] flex-1 flex-col border-t border-border p-3 sm:min-h-[124px] sm:p-4">
        <span class="block min-h-[2.5rem] overflow-hidden text-ellipsis text-xs font-bold leading-snug text-text line-clamp-2 sm:text-sm"
            style="font-family: var(--font-heading);" title="{{ $pName }}">
            {{ $pName }}
        </span>

        <span class="mt-auto flex items-baseline gap-2 pt-2">
            <span class="text-sm sm:text-base font-extrabold text-secondary truncate whitespace-nowrap" style="font-family: var(--font-heading);">
                @if ($pIsVariant && $pMinSell !== $pMaxSell)
                    @price($pMinSell) - @price($pMaxSell)
                @else
                    @price($pSelling)
                @endif
            </span>
            @if (!is_array($product) && $product->allow_custom_length)
                <span class="text-xs text-muted">/ {{ $product->default_length_m ?? 3 }} m sheet</span>
            @endif
            @if ($pStrike)
                <span class="text-[10px] sm:text-xs text-muted line-through truncate whitespace-nowrap">@price($pStrike)</span>
            @endif
        </span>
    </span>
</a>