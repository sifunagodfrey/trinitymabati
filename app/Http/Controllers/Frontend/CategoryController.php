<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Manage\Products\Category;
use App\Models\Manage\Products\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::query()
            ->where(function ($query) {
                $query->whereHas('products', fn ($products) => $products->where('is_active', 1))
                    ->orWhereHas('children.products', fn ($products) => $products->where('is_active', 1));
            })
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'parent_id', 'icon', 'featured_image']);

        $selectedSlug = trim((string) $request->query('category', ''));
        $selectedCategory = $categories->firstWhere('slug', $selectedSlug);
        if (!$selectedCategory) {
            $selectedSlug = '';
        }

        $categoryImages = Product::query()
            ->where('is_active', 1)
            ->whereIn('category_id', $categories->pluck('id'))
            ->whereNotNull('thumbnail')
            ->orderBy('id')
            ->get(['category_id', 'thumbnail'])
            ->groupBy('category_id')
            ->map(fn ($group) => $group->first()->thumbnail);

        $query = Product::query()->where('is_active', 1)->with(['variants', 'category']);
        if ($selectedCategory) {
            $ids = Category::query()
                ->where('id', $selectedCategory->id)
                ->orWhere('parent_id', $selectedCategory->id)
                ->pluck('id');
            $query->where(function ($products) use ($ids) {
                $products->whereIn('category_id', $ids)
                    ->orWhereHas('categories', fn ($categories) => $categories->whereIn('su_product_categories.id', $ids));
            });
        }

        $products = $query->orderByDesc('id')->paginate(12)->withQueryString();

        return view('frontend.categories.index', compact('categories', 'categoryImages', 'products', 'selectedSlug'));
    }

    public function show(string $slug, Request $request): View
    {
        $category = Category::query()->where('slug', $slug)->firstOrFail();
        $children = Category::query()->where('parent_id', $category->id)->orderBy('name')->get();

        $breadcrumb = [
            ['label' => 'Home', 'url' => route('frontend.home')],
            ['label' => 'Categories', 'url' => route('frontend.categories')],
        ];
        if ($category->parent_id) {
            $parent = Category::query()->find($category->parent_id);
            if ($parent) {
                $breadcrumb[] = ['label' => $parent->name, 'url' => route('frontend.categories.show', $parent->slug)];
            }
        }
        $breadcrumb[] = ['label' => $category->name, 'url' => null];

        if ($children->isNotEmpty()) {
            $sections = collect();
            foreach ($children as $child) {
                $products = Product::query()
                    ->where('is_active', 1)
                    ->where(function ($query) use ($child) {
                        $query->where('category_id', $child->id)
                            ->orWhereHas('categories', fn ($categories) => $categories->where('su_product_categories.id', $child->id));
                    })
                    ->with(['variants', 'category'])
                    ->orderByDesc('id')
                    ->limit(12)
                    ->get();
                if ($products->isNotEmpty()) {
                    $sections->push(['category' => $child, 'products' => $products]);
                }
            }
            return view('frontend.categories.show', [
                'categoryModel' => $category,
                'breadcrumb' => $breadcrumb,
                'sections' => $sections,
                'products' => null,
            ]);
        }

        $products = Product::query()
            ->where('is_active', 1)
            ->where(function ($query) use ($category) {
                $query->where('category_id', $category->id)
                    ->orWhereHas('categories', fn ($categories) => $categories->where('su_product_categories.id', $category->id));
            })
            ->with(['variants', 'category'])
            ->orderByDesc('id')
            ->paginate(12);

        return view('frontend.categories.show', [
            'categoryModel' => $category,
            'breadcrumb' => $breadcrumb,
            'sections' => collect(),
            'products' => $products,
        ]);
    }
}
