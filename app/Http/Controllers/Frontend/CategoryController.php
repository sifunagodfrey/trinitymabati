<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Manage\Products\Category;
use App\Models\Manage\Products\Product;
use App\Services\CurrencyConverterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        // ---------------
        // Only categories that contain active products, alphabetically
        // ---------------
        $categories = Category::whereIn('id', function ($q) {
                $q->select('category_id')->from('su_products')->where('is_active', 1);
            })
            ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'icon', 'featured_image']);

        // ---------------
        // Representative product image per category for cards without a
        // featured image of their own
        // ---------------
        $categoryImages = Product::where('is_active', 1)
            ->whereIn('category_id', $categories->pluck('id'))
            ->whereNotNull('thumbnail')
            ->orderBy('id')
            ->get(['category_id', 'thumbnail'])
            ->groupBy('category_id')
            ->map(fn ($group) => $group->first()->thumbnail);

        return view('frontend.categories.index', compact('categories', 'categoryImages'));
    }

    public function show(string $slug, Request $request): View
    {
        // ---------------
        // Currency service - used to format all displayed prices
        // ---------------
        $currency = app(CurrencyConverterService::class);

        // ---------------
        // Load category
        // ---------------
        $categoryModel = Category::where('slug', $slug)->firstOrFail();

        // Sub-categories of this category that contain active products
        $subcategoryModels = Category::where('parent_id', $categoryModel->id)
            ->whereIn('id', function ($q) {
                $q->select('category_id')->from('su_products')->where('is_active', 1);
            })
            ->withCount(['products' => fn($query) => $query->where('is_active', true)])
            ->orderBy('name')
            ->get();

        // ---------------
        // Top scrollable rail: sub-categories of the currently viewed
        // category, so the rail lets the user switch siblings without
        // leaving this category. First entry is the category itself
        // ("All"). If this category has no sub-categories, the rail
        // is left empty and the blade's @if hides it entirely.
        // ---------------
        $subIds = $subcategoryModels->pluck('id');

        $subImgRows = Product::where('is_active', 1)
            ->whereNotNull('thumbnail')
            ->whereIn('category_id', $subIds)
            ->orderBy('id')
            ->get(['category_id', 'thumbnail']);

        $subImages = [];
        foreach ($subImgRows as $row) {
            if (! isset($subImages[$row->category_id])) {
                $subImages[$row->category_id] = $row->thumbnail;
            }
        }

        // ---------------
        // Read filter params from request
        // ---------------
        $minPrice   = $request->input('min_price');
        $maxPrice   = $request->input('max_price');
        $priceRange = $request->input('price_range');
        $condition  = $request->input('condition');
        $sellers    = $request->input('seller', []);
        $minRating  = $request->input('min_rating');
        $counties   = $request->input('county', []);
        $sort       = $request->input('sort', '');

        // ---------------
        // Parse price_range preset into min/max when custom values not provided.
        // The form always submits empty strings for the number inputs, so check
        // for both null and empty string - not just null.
        // ---------------
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
        // Build filtered product query
        // ---------------
        $query = Product::with([
                'brand', 'label', 'reviews', 'flashSale',
                'variants:id,product_id,price,sale_price,stock_quantity', 'category:id,name',
            ])
            ->where('is_active', true)
            ->where('category_id', $categoryModel->id);

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
        // Apply sort order
        // ---------------
        $query = match ($sort) {
            'price_asc'    => $query->orderByRaw('COALESCE(sale_price, price) ASC'),
            'price_desc'   => $query->orderByRaw('COALESCE(sale_price, price) DESC'),
            'top_rated'    => $query->orderByRaw('(SELECT IFNULL(AVG(rating), 0) FROM su_product_reviews WHERE product_id = su_products.id AND status = "approved") DESC'),
            'most_reviews' => $query->orderByRaw('(SELECT COUNT(*) FROM su_product_reviews WHERE product_id = su_products.id AND status = "approved") DESC'),
            'newest'       => $query->latest(),
            default        => $query->latest(),
        };

        $productsPaginator = $query->paginate(12)->withQueryString();

        // ---------------
        // Related categories and county list for location filter
        // ---------------
        $relatedCategoryModels = Category::whereNull('parent_id')
            ->where('id', '!=', $categoryModel->id)
            ->limit(8)
            ->get();

        $countyList = DB::table('su_counties')->orderBy('name')->get(['id', 'name']);

        // ---------------
        // Build view data arrays
        // ---------------
        $category = [
            'name'        => $categoryModel->name,
            'description' => $categoryModel->description ?? '',
            'icon'        => $categoryModel->icon ?? 'fa-tag',
            'count'       => number_format($productsPaginator->total()),
            'breadcrumb'  => [
                ['label' => 'Home',       'url' => route('frontend.home')],
                ['label' => 'Categories', 'url' => route('frontend.categories')],
                ['label' => $categoryModel->name, 'url' => null],
            ],
        ];

        $subcategories = $subcategoryModels->map(fn($sub) => [
            'label' => $sub->name,
            'icon'  => $sub->icon ?? 'fa-tag',
            'count' => number_format($sub->products_count),
            'slug'  => $sub->slug,
        ])->toArray();

        $products = collect($productsPaginator->items())->map(function ($p) use ($currency) {
            $approvedReviews = $p->reviews->where('status', 'approved');
            $avgRating       = $approvedReviews->avg('rating') ?? 0;
            $reviewCount     = $approvedReviews->count();
            $basePrice       = (float) $p->price;
            $hasBasePrice    = $basePrice > 0;
            $hasDiscount     = $p->sale_price && $p->sale_price < $p->price;
            $discount        = $hasDiscount
                ? round((($p->price - $p->sale_price) / $p->price) * 100)
                : 0;

            // ---------------
            // Price display: variant range > bulk range > sale/base price
            // ---------------
            $priceStr  = null;
            $wasStr    = null;
            $bulkLabel = null;
            $showRange = false;

            if ($p->is_variant && $p->variants->isNotEmpty()) {
                $vPrices = $p->variants->map(fn ($v) =>
                    ($v->sale_price && $v->sale_price < $v->price) ? (float) $v->sale_price : (float) $v->price
                );
                $vMin     = $vPrices->min();
                $vMax     = $vPrices->max();
                $priceStr = $vMin === $vMax
                    ? $currency->format($vMin)
                    : $currency->format($vMin) . ' – ' . $currency->format($vMax);
                $showRange = true;
            } else {
                $priceStr = $currency->format((float) ($p->sale_price ?? $p->price));
                $wasStr   = $hasDiscount ? $currency->format($basePrice) : null;
            }

            // ---------------
            // Stock
            // ---------------
            $rawStock = ($p->is_variant && $p->variants->isNotEmpty())
                ? $p->variants->sum('stock_quantity')
                : $p->stock_quantity;
            $inStock = $rawStock > 0;

            return [
                'name'       => $p->name,
                'slug'       => $p->slug,
                'thumbnail'  => $p->thumbnail,
                'seller'     => 'trinity-mabati-factory',
                'price'      => $priceStr,
                'was'        => $wasStr,
                'discount'   => (! $showRange && $hasDiscount) ? $discount : null,
                'bulk_label' => $bulkLabel,
                'in_stock'   => $inStock,
                'rating'     => round($avgRating, 1),
                'reviews'    => $reviewCount,
                'verified'   => true,
                'badge'      => $p->label?->name,
                'condition'  => ucfirst($p->condition ?? 'new'),
                'sponsored'  => false,
                'wholesale'  => false,
                'model'      => $p,
            ];
        })->toArray();

        $relatedCategories = $relatedCategoryModels->map(fn($c) => [
            'label' => $c->name,
            'icon'  => $c->icon ?? 'fa-tag',
            'slug'  => $c->slug,
        ])->toArray();

        // ---------------
        // Pass current filter state back to the view for pre-filling inputs
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

        $topCategories = [];

        if ($subcategoryModels->isNotEmpty()) {
            // "All" entry - the currently viewed category itself
            $topCategories[] = [
                'label'   => 'All',
                'slug'    => $categoryModel->slug,
                'image'   => $categoryModel->featured_image
                    ? (str_starts_with($categoryModel->featured_image, 'uploads/')
                        ? asset($categoryModel->featured_image)
                        : asset('categories/featured/' . $categoryModel->featured_image))
                    : null,
                'initial' => mb_strtoupper(mb_substr($categoryModel->name, 0, 1)),
            ];

            foreach ($subcategoryModels as $sub) {
                $image = null;
                if ($sub->featured_image) {
                    $image = str_starts_with($sub->featured_image, 'uploads/')
                        ? asset($sub->featured_image)
                        : asset('categories/featured/' . $sub->featured_image);
                } elseif (isset($subImages[$sub->id])) {
                    $thumb = $subImages[$sub->id];
                    $image = str_starts_with($thumb, 'uploads/')
                        ? asset($thumb)
                        : asset('uploads/products/images/' . $thumb);
                }

                $topCategories[] = [
                    'label'   => $sub->name,
                    'slug'    => $sub->slug,
                    'image'   => $image,
                    'initial' => mb_strtoupper(mb_substr($sub->name, 0, 1)),
                ];
            }
        }

        // ---------------
        // AJAX request: return only the products grid + pagination so the
        // page does not reload when switching categories or filtering.
        // ---------------
        if ($request->ajax() || $request->boolean('ajax')) {
            return view('frontend.categories.partials.product-results', [
                'products'          => $products,
                'productsPaginator' => $productsPaginator,
                'category'          => $category,
            ]);
        }

        return view('frontend.categories.show', [
            'slug'              => $slug,
            'category'          => $category,
            'subcategories'     => $subcategories,
            'topCategories'     => $topCategories,
            'hasSubcategories'  => count($subcategories) > 0,
            'productsPaginator' => $productsPaginator,
            'products'          => $products,
            'relatedCategories' => $relatedCategories,
            'filters'           => $filters,
            'countyList'        => $countyList,
        ]);
    }
}
