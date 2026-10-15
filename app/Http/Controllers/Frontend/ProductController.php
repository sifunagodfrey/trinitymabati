<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Client\Wishlist;
use App\Models\Frontend\Cart;
use App\Models\Manage\Products\Brand;
use App\Models\Manage\Products\Category;
use App\Models\Manage\Products\Label;
use App\Models\Manage\Products\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // ---------------
    // Products Listing (unchanged)
    // ---------------
    public function index()
    {
        $query = Product::with([
                'category', 'brand', 'label',
                'variants:id,product_id,price,sale_price,stock_quantity',
            ])
            ->where('is_active', true);

        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if (request('category_id')) {
            $query->where('category_id', request('category_id'));
        }
        if (request('brand_id')) {
            $query->where('brand_id', request('brand_id'));
        }
        if (request('label_id')) {
            $query->where('label_id', request('label_id'));
        }

        $minPrice   = request('min_price');
        $maxPrice   = request('max_price');
        $priceRange = request('price_range');
        $condition  = request('condition');

        $customPriceAbsent = ($minPrice === null || $minPrice === '') && ($maxPrice === null || $maxPrice === '');
        if ($priceRange && $customPriceAbsent) {
            [$minPrice, $maxPrice] = match ($priceRange) {
                '0-5000'       => [0, 5000],
                '5000-20000'   => [5000, 20000],
                '20000-50000'  => [20000, 50000],
                '50000-100000' => [50000, 100000],
                '100000+'      => [100000, null],
                default        => [null, null],
            };
        }

        $effectivePriceSql = "CASE
            WHEN su_products.is_variant = 1
                THEN COALESCE((SELECT MIN(COALESCE(pv.sale_price, pv.price)) FROM su_product_variants pv WHERE pv.product_id = su_products.id), 0)
            ELSE COALESCE(su_products.sale_price, su_products.price, 0)
        END";

        if ($minPrice !== null && $minPrice !== '') {
            $query->whereRaw("({$effectivePriceSql}) >= ?", [$minPrice]);
        }
        if ($maxPrice !== null && $maxPrice !== '') {
            $query->whereRaw("({$effectivePriceSql}) <= ?", [$maxPrice]);
        }
        if ($condition && $condition !== 'all') {
            $query->where('condition', $condition);
        }

        match (request('sort', 'latest')) {
            'price_asc'    => $query->orderByRaw('COALESCE(sale_price, price) ASC'),
            'price_desc'   => $query->orderByRaw('COALESCE(sale_price, price) DESC'),
            'name_asc'     => $query->orderBy('name'),
            'top_rated'    => $query->orderByRaw('(SELECT IFNULL(AVG(rating), 0) FROM su_product_reviews WHERE product_id = su_products.id AND status = "approved") DESC'),
            'most_reviews' => $query->orderByRaw('(SELECT COUNT(*) FROM su_product_reviews WHERE product_id = su_products.id AND status = "approved") DESC'),
            default        => $query->latest(),
        };

        $products = $query->paginate(24)->withQueryString();

        $searchTerm = request('search');

        $baseCountQuery = fn ($q) => $q
            ->where('is_active', true)
            ->when($searchTerm, fn ($q) => $q->where(
                fn ($s) => $s->where('name', 'like', "%{$searchTerm}%")
                             ->orWhere('sku',  'like', "%{$searchTerm}%")
            ))
            ->when($minPrice !== null && $minPrice !== '', fn ($q) => $q->whereRaw("({$effectivePriceSql}) >= ?", [$minPrice]))
            ->when($maxPrice !== null && $maxPrice !== '', fn ($q) => $q->whereRaw("({$effectivePriceSql}) <= ?", [$maxPrice]))
            ->when($condition && $condition !== 'all', fn ($q) => $q->where('condition', $condition));

        $categories = Category::withCount([
            'products' => fn ($q) => $baseCountQuery($q)
                ->when(request('brand_id'), fn ($q) => $q->where('brand_id', request('brand_id')))
                ->when(request('label_id'), fn ($q) => $q->where('label_id', request('label_id'))),
        ])->orderBy('name')->get();

        $brands = Brand::withCount([
            'products' => fn ($q) => $baseCountQuery($q)
                ->when(request('category_id'), fn ($q) => $q->where('category_id', request('category_id')))
                ->when(request('label_id'),    fn ($q) => $q->where('label_id',    request('label_id'))),
        ])->orderBy('name')->get();

        $labels = Label::withCount([
            'products' => fn ($q) => $baseCountQuery($q)
                ->when(request('category_id'), fn ($q) => $q->where('category_id', request('category_id')))
                ->when(request('brand_id'),    fn ($q) => $q->where('brand_id',    request('brand_id'))),
        ])->orderBy('name')->get();

        $wishlistIds = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : [];

        $countyList = DB::table('su_counties')->orderBy('name')->get(['id', 'name']);

        $filters = [
            'min_price'   => request('min_price', ''),
            'max_price'   => request('max_price', ''),
            'price_range' => request('price_range', ''),
            'condition'   => $condition ?? '',
        ];

        return view('frontend.products.index', compact('products', 'categories', 'brands', 'labels', 'wishlistIds', 'countyList', 'filters'));
    }

    // ---------------
    // Single Product
    // ---------------
    public function show(string $slug)
    {
        if (!Product::where('slug', $slug)->where('is_active', true)->exists()) {
            $redirectId = DB::table('su_seo_slug_redirects')->where('kind', 'product')->where('old_slug', $slug)->value('entity_id');
            $target = $redirectId ? Product::where('is_active', true)->find($redirectId) : null;
            if ($target) return redirect()->route('frontend.products.show', $target->slug, 301);
        }
        $product = Product::with([
            'category', 'brand', 'label',
            'categories', 'labels',
            'variants.variantAttributes.attributeValue', 'reviews.user',
            'media', 'flashSale',
        ])->where('slug', $slug)
          ->where('is_active', true)
          ->firstOrFail();

        $attrGroups = [];
        foreach ($product->attributes()->with('values')->get() as $attr) {
            $attrGroups[$attr->id] = [
                'id'     => $attr->id,
                'name'   => $attr->name,
                'values' => $attr->values->pluck('value')->toArray(),
            ];
        }

        $normalizeImagePath = fn (string $path): string =>
            str_starts_with($path, 'uploads/')
                ? $path
                : 'uploads/products/images/' . $path;

        $allImages = [];
        if ($product->thumbnail) {
            $allImages[] = asset($normalizeImagePath($product->thumbnail));
        }
        foreach ($product->media->where('type', 'image') as $media) {
            $allImages[] = asset($normalizeImagePath($media->file_path));
        }
        if (empty($allImages)) {
            $allImages[] = asset('public/images/placeholder.png');
        }

        $approvedReviews = $product->reviews->where('status', 'approved');
        $avgRating       = $approvedReviews->avg('rating') ?? 0;
        $reviewCount     = $approvedReviews->count();

        $basePrice    = (float) ($product->sale_price && $product->sale_price < $product->price ? $product->sale_price : $product->price);
        $baseOriginal = (float) $product->price;
        $hasDiscount  = $product->sale_price && $product->sale_price < $product->price;

        $baseStock = \App\Services\StockAvailability::forProduct($product);

        $variantsJson = $product->variants->map(fn ($variant) => [
            'id'             => $variant->id,
            'variant_code'   => $variant->variant_code,
            'price'          => (float) $variant->price,
            'sale_price'     => $variant->sale_price ? (float) $variant->sale_price : null,
            'stock_quantity' => \App\Services\StockAvailability::normalize($variant->stock_quantity),
            'image'          => $variant->image ? asset($variant->image) : null,
            'attrs'          => $variant->variantAttributes->map(fn ($va) => [
                'attribute_id' => $va->attribute_id,
                'value'        => optional($va->attributeValue)->value ?? '',
            ])->values(),
        ])->values();

        $variantMinPrice = null;
        $variantMaxPrice = null;
        if ($product->is_variant && $product->variants->isNotEmpty()) {
            $effectivePrices = $product->variants->map(
                fn ($v) => ($v->sale_price && $v->sale_price < $v->price)
                    ? (float) $v->sale_price
                    : (float) $v->price
            );
            $variantMinPrice = $effectivePrices->min();
            $variantMaxPrice = $effectivePrices->max();
            // If only one distinct price, do not treat as range
            if ($variantMinPrice == $variantMaxPrice) {
                $variantMaxPrice = null;
            }
        }

        $bulkMinPrice  = null;
        $bulkTiersJson = collect();

        $isFlashSale = $product->flashSale
            && $product->flashSale->status === 'active'
            && now()->between($product->flashSale->start_time, $product->flashSale->end_time);
        $flashDiscount = $isFlashSale ? $product->flashSale->discount_percentage : 0;
        $flashEndsAt   = $isFlashSale ? $product->flashSale->end_time->timestamp * 1000 : 0;
        $saleDiscount = $hasDiscount
            ? round((($product->price - $product->sale_price) / $product->price) * 100)
            : 0;

        // ---------------
        // Related products - same category
        // ---------------
        $sellerName          = null;
        $relatedSectionTitle = null;
        $relatedProducts     = collect();

        if ($product->category_id) {
            $relatedProducts = Product::with(['brand', 'label', 'variants', 'category:id,name'])
                ->where('is_active', true)
                ->where('id', '!=', $product->id)
                ->where('category_id', $product->category_id)
                ->inRandomOrder()
                ->limit(6)
                ->get();
            $relatedSectionTitle = 'More in ' . ($product->category?->name ?? 'this Category');
        }

        // -------------------------
        // ENHANCED RELATED PRODUCTS WITH PRICE METADATA
        // -------------------------
        $relatedProductsWithMeta = $relatedProducts->map(function ($related) {
            $meta = $this->computePriceMetadata($related);
            $related->price_meta = $meta;
            return $related;
        });

        $inWishlist = Auth::check()
            && Wishlist::where('user_id', Auth::id())->where('product_id', $product->id)->exists();

        $cartItems = [];
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->with('items')->first();
            if ($cart) {
                foreach ($cart->items as $item) {
                    $cartItems[] = [
                        'product_id' => $item->product_id,
                        'variant_id' => $item->variant_id,
                        'sheet_length_m' => $item->sheet_length_m,
                    ];
                }
            }
        } else {
            $sessionCart = session('cart', []);
            foreach ($sessionCart as $item) {
                $cartItems[] = [
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'] ?? null,
                    'sheet_length_m' => $item['sheet_length_m'] ?? null,
                ];
            }
        }

        return view('frontend.products.show', compact(
            'product',
            'attrGroups',
            'allImages',
            'approvedReviews',
            'avgRating',
            'reviewCount',
            'basePrice',
            'baseOriginal',
            'baseStock',
            'hasDiscount',
            'variantsJson',
            'variantMinPrice',
            'variantMaxPrice',
            'bulkMinPrice',
            'bulkTiersJson',
            'isFlashSale',
            'flashDiscount',
            'flashEndsAt',
            'saleDiscount',
            'relatedProducts',
            'relatedProductsWithMeta',
            'sellerName',
            'relatedSectionTitle',
            'inWishlist',
            'cartItems'
        ));
    }

    /**
     * Compute price metadata for a product (used for related products).
     * Returns an array with keys: type, low, high, has_sale, regular, sale, is_bulk_only.
     */
    private function computePriceMetadata(Product $product): ?array
    {
        $variants = $product->variants ?? collect();
        $bulkTiers = collect();
        $basePrice = (float) $product->price;
        $salePrice = $product->sale_price ? (float) $product->sale_price : null;
        $hasSale = ($salePrice !== null && $salePrice < $basePrice && $salePrice > 0);

        // ----- Variant products -----
        $variantMin = null;
        $variantMax = null;
        if ($product->is_variant && $variants->isNotEmpty()) {
            $prices = [];
            foreach ($variants as $v) {
                $price = (float) ($v->sale_price ?? $v->price);
                if ($price > 0) $prices[] = $price;
            }
            if (!empty($prices)) {
                $variantMin = min($prices);
                $variantMax = max($prices);
            }
        }

        // ----- Bulk‑only products (base price = 0 and bulk tiers exist) -----
        $isBulkOnly = ($basePrice == 0 && $bulkTiers->isNotEmpty());
        $bulkMin = null;
        $bulkMax = null;
        if ($isBulkOnly) {
            $unitPrices = [];
            foreach ($bulkTiers as $tier) {
                $price = (float) $tier->price_per_unit;
                if ($price > 0) $unitPrices[] = $price;
            }
            if (!empty($unitPrices)) {
                $bulkMin = min($unitPrices);
                $bulkMax = max($unitPrices);
            }
        }

        // Decide display type
        if ($variantMin !== null && $variantMin != $variantMax) {
            $displayType = 'variant_range';
            $displayLow = $variantMin;
            $displayHigh = $variantMax;
        } elseif ($isBulkOnly && $bulkMin !== null && $bulkMin != $bulkMax) {
            $displayType = 'bulk_range';
            $displayLow = $bulkMin;
            $displayHigh = $bulkMax;
        } elseif ($hasSale) {
            $displayType = 'sale';
            $displayLow = $salePrice;
            $displayHigh = $basePrice;
        } else {
            // For single variant or single tier, use simple price
            if ($variantMin !== null && $variantMin == $variantMax) {
                $displayType = 'simple';
                $displayLow = $variantMin;
                $displayHigh = null;
            } elseif ($isBulkOnly && $bulkMin !== null && $bulkMin == $bulkMax) {
                $displayType = 'simple';
                $displayLow = $bulkMin;
                $displayHigh = null;
            } elseif ($basePrice > 0) {
                $displayType = 'simple';
                $displayLow = $basePrice;
                $displayHigh = null;
            } else {
                // No valid price found
                return null;
            }
        }

        return [
            'type'          => $displayType,
            'low'           => $displayLow,
            'high'          => $displayHigh,
            'has_sale'      => $hasSale,
            'regular'       => $basePrice,
            'sale'          => $salePrice,
            'is_bulk_only'  => $isBulkOnly,
        ];
    }
}