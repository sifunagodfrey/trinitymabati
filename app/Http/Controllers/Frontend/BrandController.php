<?php

/* -------------------
   Frontend brand controller. Lists the brands Trinity Mabati Factory carries and
   shows a single brand with its active products. Product rows pass
   Eloquent models so every listing renders through the shared product
   card partial.
------------------- */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Manage\Products\Brand;
use App\Models\Manage\Products\Product;
use Illuminate\View\View;

class BrandController extends Controller
{
    // ---------------
    // Brand directory - all brands, those with a logo first
    // ---------------
    public function index(): View
    {
        $brands = Brand::query()
            ->withCount(['products as active_products_count' => fn ($q) => $q->where('is_active', 1)])
            ->orderByRaw('CASE WHEN logo IS NULL OR logo = "" THEN 1 ELSE 0 END')
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'logo', 'banner_image', 'description']);

        return view('frontend.brands.index', compact('brands'));
    }

    // ---------------
    // Single brand and its active products
    // ---------------
    public function show(string $slug): View
    {
        $brand = Brand::where('slug', $slug)->firstOrFail();

        $products = Product::where('is_active', 1)
            ->where('brand_id', $brand->id)
            ->with(['variants:id,product_id,price,sale_price,stock_quantity', 'category:id,name'])
            ->latest()
            ->paginate(12);

        return view('frontend.brands.show', compact('brand', 'products'));
    }
}
