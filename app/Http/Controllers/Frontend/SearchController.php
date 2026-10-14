<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Client\Wishlist;
use App\Models\Manage\Products\Brand;
use App\Models\Manage\Products\Category;
use App\Models\Manage\Products\Label;
use App\Models\Manage\Products\Product;
use App\Services\CurrencyConverterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    // ---------------
    // Predictive Search Suggestions (JSON)
    // ---------------
    public function suggestions()
    {
        $q = trim(request('q', ''));

        $products = Product::where('is_active', true)
            ->when($q !== '', fn ($query) => $query->where('name', 'like', "%{$q}%"))
            ->with([
                'category:id,name',
                'variants:id,product_id,price,sale_price',
            ])
            ->select('id', 'name', 'slug', 'thumbnail', 'price', 'sale_price', 'currency',
                     'category_id', 'is_variant')
            ->orderByRaw("CASE WHEN LOWER(name) LIKE LOWER(?) THEN 0 ELSE 1 END", ["{$q}%"])
            ->orderByDesc('id')
            ->limit(10)
            ->get()
            ->map(function ($p) {
                $thumb = $p->thumbnail
                    ? asset(\str_starts_with($p->thumbnail, 'uploads/')
                        ? $p->thumbnail
                        : 'uploads/products/images/' . $p->thumbnail)
                    : null;

                // ---------------
                // Compute price display: variant range > bulk range > base/sale price
                // ---------------
                $currency     = $p->currency ?? 'KES';
                $basePrice    = (float) $p->price;
                $priceDisplay = null;

                if ($p->is_variant && $p->variants->isNotEmpty()) {
                    $vPrices = $p->variants->map(fn ($v) =>
                        ($v->sale_price && $v->sale_price < $v->price) ? (float) $v->sale_price : (float) $v->price
                    );
                    $vMin = $vPrices->min();
                    $vMax = $vPrices->max();
                    $priceDisplay = $vMin === $vMax
                        ? $currency . ' ' . number_format($vMin, 2)
                        : $currency . ' ' . number_format($vMin, 2) . ' – ' . number_format($vMax, 2);
                }

                if ($priceDisplay === null) {
                    $display      = ($p->sale_price && $p->sale_price < $p->price) ? (float) $p->sale_price : $basePrice;
                    $priceDisplay = $currency . ' ' . number_format($display, 2);
                }

                return [
                    'id'            => $p->id,
                    'name'          => $p->name,
                    'slug'          => $p->slug,
                    'url'           => route('frontend.products.show', $p->slug),
                    'thumb'         => $thumb,
                    'price_display' => $priceDisplay,
                    'category'      => $p->category?->name,
                ];
            });

        return response()->json($products);
    }

    // ---------------
    // Search Results (with advanced filters)
    // ---------------
    public function index(Request $request)
    {
        $q = trim(request('q', ''));

        if ($q === '') {
            return redirect()->route('frontend.products');
        }

        $currency = app(CurrencyConverterService::class);

        // ---------------
        // Read filter params
        // ---------------
        $minPrice   = $request->input('min_price');
        $maxPrice   = $request->input('max_price');
        $priceRange = $request->input('price_range');
        $condition  = $request->input('condition');
        $sellers    = $request->input('seller', []);
        $minRating  = $request->input('min_rating');
        $counties   = $request->input('county', []);
        $sort       = $request->input('sort', '');

        // Parse price_range preset when custom min/max not provided
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

        // ---------------
        // Base query with relevance ordering
        // ---------------
        $query = Product::with([
                'category', 'brand', 'label',
                'variants:id,product_id,price,sale_price,stock_quantity', 'reviews'
            ])
            ->where('is_active', true)
            ->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhere('short_description', 'like', "%{$q}%")
                    ->orWhereHas('brand', fn ($b) => $b->where('name', 'like', "%{$q}%"))
                    ->orWhereHas('category', fn ($c) => $c->where('name', 'like', "%{$q}%"));
            });

        // ---------------
        // Apply filters
        // ---------------

        // ---------------
        // Single category filter - used by the header search dropdown
        // and the category quick-filter chips on the results page.
        // ---------------
        $singleCategory = (int) (request('cat') ?: request('category_id'));
        if ($singleCategory > 0) {
            $query->where('category_id', $singleCategory);
        }

        // ---------------
        // Effective price - resolves the right price source per product type
        // ---------------
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
        if (in_array('brand', $sellers)) {
            $query->whereNotNull('brand_id');
        }
        if ($minRating) {
            $query->whereIn('id', function ($sub) use ($minRating) {
                $sub->from('su_product_reviews')
                    ->select('product_id')
                    ->where('status', 'approved')
                    ->groupBy('product_id')
                    ->havingRaw('AVG(rating) >= ?', [$minRating]);
            });
        }
        // ---------------
        // Apply sorting (override relevance if explicit sort chosen)
        // ---------------
        if (in_array($sort, ['price_asc', 'price_desc', 'name_asc', 'top_rated', 'most_reviews', 'newest'])) {
            $query->reorder();
            $query = match ($sort) {
                'price_asc'    => $query->orderByRaw('COALESCE(sale_price, price) ASC'),
                'price_desc'   => $query->orderByRaw('COALESCE(sale_price, price) DESC'),
                'name_asc'     => $query->orderBy('name'),
                'top_rated'    => $query->orderByRaw('(SELECT IFNULL(AVG(rating), 0) FROM su_product_reviews WHERE product_id = su_products.id AND status = "approved") DESC'),
                'most_reviews' => $query->orderByRaw('(SELECT COUNT(*) FROM su_product_reviews WHERE product_id = su_products.id AND status = "approved") DESC'),
                'newest'       => $query->latest(),
                default        => $query,
            };
        } else {
            // Default relevance order
            $query->orderByRaw("
                CASE
                    WHEN LOWER(name) = LOWER(?) THEN 1
                    WHEN LOWER(name) LIKE LOWER(?) THEN 2
                    WHEN LOWER(name) LIKE LOWER(?) THEN 3
                    WHEN LOWER(sku) = LOWER(?) THEN 4
                    ELSE 5
                END
            ", [$q, "{$q}%", "%{$q}%", $q]);
        }

        $products = $query->paginate(24)->withQueryString();

        // ---------------
        // Sidebar data (categories, brands, labels) with counts that respect active filters
        // ---------------
        $baseFilteredQuery = fn ($subQuery) => $subQuery
            ->where('is_active', true)
            ->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhere('short_description', 'like', "%{$q}%")
                    ->orWhereHas('brand', fn ($b) => $b->where('name', 'like', "%{$q}%"))
                    ->orWhereHas('category', fn ($c) => $c->where('name', 'like', "%{$q}%"));
            })
            ->when($minPrice !== null && $minPrice !== '', fn($q) => $q->whereRaw("({$effectivePriceSql}) >= ?", [$minPrice]))
            ->when($maxPrice !== null && $maxPrice !== '', fn($q) => $q->whereRaw("({$effectivePriceSql}) <= ?", [$maxPrice]))
            ->when($condition && $condition !== 'all', fn($q) => $q->where('condition', $condition))
            ->when(in_array('brand', $sellers), fn($q) => $q->whereNotNull('brand_id'))
            ->when($minRating, fn($q) => $q->whereIn('id', function ($sub) use ($minRating) {
                $sub->from('su_product_reviews')
                    ->select('product_id')
                    ->where('status', 'approved')
                    ->groupBy('product_id')
                    ->havingRaw('AVG(rating) >= ?', [$minRating]);
            }))
;

        $categories = Category::withCount([
            'products' => fn($q) => $baseFilteredQuery($q)
        ])->orderBy('name')->get();

        $brands = Brand::withCount([
            'products' => fn($q) => $baseFilteredQuery($q)
        ])->orderBy('name')->get();

        $labels = Label::withCount([
            'products' => fn($q) => $baseFilteredQuery($q)
        ])->orderBy('name')->get();

        // ---------------
        // Matching categories for quick-filter row
        // ---------------
        $matchingCategories = Category::where('name', 'like', "%{$q}%")
            ->withCount(['products' => fn ($p) => $baseFilteredQuery($p)])
            ->having('products_count', '>', 0)
            ->orderByDesc('products_count')
            ->limit(6)
            ->get();

        // ---------------
        // County list for location filter
        // ---------------
        $countyList = DB::table('su_counties')->orderBy('name')->get(['id', 'name']);

        // ---------------
        // Wishlist IDs
        // ---------------
        $wishlistIds = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : [];

        // ---------------
        // Filter state to pre-fill the sidebar
        // ---------------
        $filters = [
            'min_price'   => $request->input('min_price', ''),
            'max_price'   => $request->input('max_price', ''),
            'price_range' => $request->input('price_range', ''),
            'condition'   => $condition ?? '',
            'seller'      => is_array($sellers) ? $sellers : [],
            'min_rating'  => $minRating ?? '',
            'county'      => is_array($counties) ? array_map('strval', $counties) : [],
            'sort'        => $sort,
        ];

        return view('frontend.search.results', compact(
            'products', 'q', 'categories', 'brands', 'labels',
            'wishlistIds', 'matchingCategories', 'countyList', 'filters'
        ));
    }
}
