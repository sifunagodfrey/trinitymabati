<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Core\Faq;
use App\Models\Core\TeamMember;
use App\Models\Core\Partner;
use App\Models\Manage\Products\Category;
use App\Models\Manage\Products\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $slugs = ['tile-profiles', 'corrugated-sheets'];

        $mainCategories = Category::query()
            ->whereNull('parent_id')
            ->orderBy('id')
            ->get();

        $sections = collect($slugs)->mapWithKeys(function ($slug) use ($mainCategories) {
            $parent = $mainCategories->firstWhere('slug', $slug);
            if (!$parent) return [$slug => collect()];

            $categoryIds = Category::query()->where('parent_id', $parent->id)
                ->pluck('id')->push($parent->id)->unique()->all();

            return [$slug => Product::query()
                ->where('is_active', 1)
                ->whereIn('category_id', $categoryIds)
                ->with(['variants:id,product_id,price,sale_price,stock_quantity', 'category:id,name'])
                ->orderByDesc('id')
                ->limit(10)
                ->get()];
        });

        $faqs = Faq::activeOrdered()
            ->where(function ($query) {
                foreach (['roof', 'mabati', 'sheet', 'quotation', 'gauge', 'delivery', 'warranty', 'KEBS'] as $term) {
                    $query->orWhere('question', 'like', '%' . $term . '%');
                }
            })
            ->limit(8)
            ->get();

        $teamMembers = TeamMember::published()->displayOrder()->get();
        $partners = Partner::published()->displayOrder()->get();

        return view('frontend.home.index', compact('mainCategories', 'sections', 'faqs', 'teamMembers', 'partners'));
    }
}
