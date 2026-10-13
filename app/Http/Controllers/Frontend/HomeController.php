<?php

/* -------------------
   Frontend home controller. Builds the homepage sections: hero
   slideshow, main category grid, quick actions, shop by health concern,
   top selling, popular products, shop by stage, new arrivals and
   recommended brands. Product rows pass Eloquent models so every
   section renders through the shared product card partial.
------------------- */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Core\Banner;
use App\Models\Manage\Products\Category;
use App\Models\Manage\Products\Brand;
use App\Models\Manage\Products\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    // ---------------
    // Homepage
    // ---------------
    public function index(): View
    {
        // ---------------
        // Hero Banners - active slides in display order
        // ---------------
        $banners = Banner::activeOrdered()->get();

        // ---------------
        // Main Categories - prefer categories that actually contain
        // active products so each card can show a real product image,
        // falling back to the icon-flagged top-level categories.
        // ---------------
        $mainCategories = Category::query()
            ->whereIn('id', function ($q) {
                $q->select('category_id')->from('su_products')->where('is_active', 1);
            })
            ->withCount(['products as active_products_count' => fn ($q) => $q->where('is_active', 1)])
            ->orderByDesc('active_products_count')
            ->orderBy('name')
            ->limit(12)
            ->get(['id', 'name', 'slug', 'icon', 'featured_image']);

        if ($mainCategories->isEmpty()) {
            $mainCategories = Category::whereNotNull('icon')
                ->where('icon', '!=', '')
                ->orderBy('id')
                ->limit(12)
                ->get(['id', 'name', 'slug', 'icon', 'featured_image']);
        }

        // ---------------
        // Representative product image per category, used when the
        // category has no featured image of its own.
        // ---------------
        $categoryImages = Product::where('is_active', 1)
            ->whereIn('category_id', $mainCategories->pluck('id'))
            ->whereNotNull('thumbnail')
            ->orderBy('id')
            ->get(['category_id', 'thumbnail'])
            ->groupBy('category_id')
            ->map(fn ($group) => $group->first()->thumbnail);

        // ---------------
        // Shop by Health Concern - curated category links (only those
        // that actually exist in the catalog are shown)
        // ---------------
        $concernMap = [
            ['label' => 'Sleep & Stress',     'icon' => 'fas fa-moon',          'slug' => 'stress-and-sleep-support'],
            ['label' => 'Pregnancy',          'icon' => 'fas fa-person-pregnant','slug' => 'pregnancy-breastfeeding-supplements'],
            ['label' => 'Energy & Immunity',  'icon' => 'fas fa-bolt',          'slug' => 'immunity-boosters'],
            ['label' => 'Skin & Hair',        'icon' => 'fas fa-spa',           'slug' => 'skincare'],
            ['label' => 'Baby Health',        'icon' => 'fas fa-baby',          'slug' => 'baby-care'],
            ['label' => 'Gut Health',         'icon' => 'fas fa-leaf',          'slug' => 'probiotics'],
            ['label' => 'Oral Care',          'icon' => 'fas fa-tooth',         'slug' => 'oral-care'],
            ['label' => 'Feminine Care',      'icon' => 'fas fa-venus',         'slug' => 'feminine-care'],
        ];

        $existingSlugs  = Category::whereIn('slug', collect($concernMap)->pluck('slug'))->pluck('slug')->all();
        $healthConcerns = collect($concernMap)
            ->filter(fn ($c) => in_array($c['slug'], $existingSlugs))
            ->values();

        // ---------------
        // Top Selling This Week - by units sold in the last 7 days,
        // topped up with all-time best sellers, then latest products
        // ---------------
        $topSelling = $this->bestSellers(now()->subDays(7), 8);
        if ($topSelling->count() < 4) {
            $topSelling = $this->bestSellers(null, 8);
        }
        if ($topSelling->count() < 4) {
            $topSelling = $this->productBase()->latest()->limit(8)->get();
        }

        // ---------------
        // Popular Products - most viewed active products
        // ---------------
        $popular = $this->productBase()
            ->orderByDesc('views')
            ->orderByDesc('id')
            ->limit(8)
            ->get();

        // ---------------
        // New Arrivals
        // ---------------
        $newArrivals = $this->productBase()->latest()->limit(8)->get();

        // ---------------
        // Shop by Stage - curated cards for the motherhood journey
        // ---------------
        $stageMap = [
            ['title' => 'Pregnant', 'text' => 'Prenatal vitamins, supplements and comfort essentials.', 'icon' => 'fas fa-person-pregnant', 'slug' => 'pregnancy-breastfeeding-supplements'],
            ['title' => 'New Mom',  'text' => 'Feeding, recovery and newborn care must-haves.',          'icon' => 'fas fa-baby-carriage',   'slug' => 'baby-feeding'],
            ['title' => 'Mama Bear','text' => 'Wellness, beauty and self-care for every day.',           'icon' => 'fas fa-heart',           'slug' => 'wellness'],
        ];
        $stageSlugs = Category::whereIn('slug', collect($stageMap)->pluck('slug'))->pluck('slug')->all();
        $stages     = collect($stageMap)->map(function ($stage) use ($stageSlugs) {
            $stage['url'] = in_array($stage['slug'], $stageSlugs)
                ? route('frontend.categories.show', $stage['slug'])
                : route('frontend.categories');

            return $stage;
        });

        // ---------------
        // Recommended Brands - those with a logo first
        // ---------------
        $brands = Brand::orderByRaw('CASE WHEN logo IS NULL OR logo = "" THEN 1 ELSE 0 END')
            ->orderBy('name')
            ->limit(12)
            ->get(['id', 'name', 'slug', 'logo']);

        return view('frontend.home.index', compact(
            'banners',
            'mainCategories',
            'categoryImages',
            'healthConcerns',
            'topSelling',
            'popular',
            'newArrivals',
            'stages',
            'brands'
        ));
    }

    // ---------------
    // Base product query with the relations the shared card needs
    // ---------------
    private function productBase()
    {
        return Product::where('is_active', true)
            ->with(['variants:id,product_id,price,sale_price,stock_quantity', 'category:id,name']);
    }

    // ---------------
    // Best sellers by units sold, optionally since a given date
    // ---------------
    private function bestSellers($since, int $limit)
    {
        $ids = DB::table('su_order_items')
            ->select('product_id', DB::raw('SUM(quantity) as units'))
            ->when($since, fn ($q) => $q->where('created_at', '>=', $since))
            ->groupBy('product_id')
            ->orderByDesc('units')
            ->limit($limit)
            ->pluck('product_id')
            ->all();

        if (empty($ids)) {
            return collect();
        }

        return $this->productBase()
            ->whereIn('id', $ids)
            ->get()
            ->sortBy(fn ($p) => array_search($p->id, $ids))
            ->values();
    }
}
