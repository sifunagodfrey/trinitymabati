<?php

namespace App\Http\Controllers\Manage\Products;

use App\Http\Controllers\Controller;
use App\Models\Manage\Products\Brand;
use App\Models\Manage\Products\Category;
use App\Models\Manage\Products\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\ReportExportTrait;

class ReportsController extends Controller
{
    use ReportExportTrait;

    // ---------------
    // Product Reports Overview
    // ---------------
    public function index(Request $request)
    {
        // ---------------
        // Summary stats (variant-aware out-of-stock)
        // ---------------
        $stats = [
            'total'        => Product::count(),
            'active'       => Product::where('is_active', true)->count(),
            'out_of_stock' => Product::where(function ($q) {
                $q->where(function ($q2) {
                    $q2->where('is_variant', false)->where('stock_quantity', '<=', 0);
                })->orWhere(function ($q2) {
                    $q2->where('is_variant', true)
                        ->whereDoesntHave('variants', fn ($v) => $v->where('stock_quantity', '>', 0));
                });
            })->count(),
            'low_stock'    => Product::where('is_variant', false)
                ->whereBetween('stock_quantity', [1, 9])
                ->count(),
        ];

        // ---------------
        // Top seller this month (by units sold)
        // ---------------
        $topSeller = Product::select('su_products.id', 'su_products.name')
            ->join('su_order_items', 'su_order_items.product_id', '=', 'su_products.id')
            ->whereMonth('su_order_items.created_at', now()->month)
            ->groupBy('su_products.id', 'su_products.name')
            ->orderByRaw('SUM(su_order_items.quantity) DESC')
            ->first();

        // ---------------
        // Most viewed product
        // ---------------
        $mostViewed = Product::orderByDesc('views')->first(['id', 'name']);

        // ---------------
        // Searchable product performance table
        // ---------------
        $search = $request->input('search', '');

        $products = Product::select([
                'su_products.id',
                'su_products.category_id',
                'su_products.name',
                'su_products.stock_quantity',
                'su_products.views',
                'su_products.is_variant',
                'su_products.is_active',
                'su_products.cost_price',
                DB::raw('(SELECT COALESCE(SUM(oi.quantity), 0) FROM su_order_items oi WHERE oi.product_id = su_products.id) AS units_sold'),
                DB::raw('(SELECT COALESCE(SUM(oi.quantity * oi.price), 0) FROM su_order_items oi WHERE oi.product_id = su_products.id) AS revenue'),
                DB::raw('(SELECT COALESCE(SUM(oi.quantity * COALESCE(pv.cost_price, su_products.cost_price, 0)), 0)
                          FROM su_order_items oi
                          LEFT JOIN su_product_variants pv ON pv.id = oi.variant_id
                          WHERE oi.product_id = su_products.id) AS est_cost'),
            ])
            ->with('category:id,name')
            ->when($search, fn ($q) => $q->where('su_products.name', 'like', "%{$search}%"))
            ->orderByDesc('su_products.id')
            ->paginate(15)
            ->withQueryString();

        // ---------------
        // Category & brand breakdown
        // ---------------
        $byCategory = Category::withCount('products')
            ->having('products_count', '>', 0)
            ->orderByDesc('products_count')
            ->take(10)
            ->get();

        $byBrand = Brand::withCount('products')
            ->having('products_count', '>', 0)
            ->orderByDesc('products_count')
            ->take(10)
            ->get();

        if ($request->input('export') === 'csv' || $request->input('export') === 'pdf') {
            $exportRows = Product::select([
                    'su_products.id',
                    'su_products.category_id',
                    'su_products.name',
                    'su_products.stock_quantity',
                    'su_products.views',
                    'su_products.is_variant',
                    'su_products.is_active',
                    DB::raw('(SELECT COALESCE(SUM(oi.quantity), 0) FROM su_order_items oi WHERE oi.product_id = su_products.id) AS units_sold'),
                    DB::raw('(SELECT COALESCE(SUM(oi.quantity * oi.price), 0) FROM su_order_items oi WHERE oi.product_id = su_products.id) AS revenue'),
                ])
                ->with('category:id,name')
                ->when($search, fn ($q) => $q->where('su_products.name', 'like', "%{$search}%"))
                ->orderByDesc('su_products.id')
                ->get();

            if ($request->input('export') === 'csv') {
                $rows = $exportRows->map(function ($product) {
                    return [
                        $product->id,
                        $product->name,
                        $product->category?->name ?? 'Uncategorized',
                        number_format((int) $product->units_sold),
                        number_format((float) $product->revenue, 2, '.', ''),
                        number_format((int) $product->views),
                        $product->is_variant ? 'Variant' : number_format((int) $product->stock_quantity),
                        $product->is_variant ? 'Variants' : ($product->is_active ? 'Active' : 'Inactive'),
                    ];
                })->toArray();

                return $this->exportCsv(
                    'product-report-' . now()->format('Ymd_His') . '.csv',
                    ['ID', 'Name', 'Category', 'Units Sold', 'Revenue (KES)', 'Views', 'Stock', 'Status'],
                    $rows
                );
            }

            $lines = [
                'Product Performance Report',
                'Generated: ' . now()->format('Y-m-d H:i:s'),
                '',
                'Name | Category | Units Sold | Revenue (KES) | Views | Stock | Status',
            ];

            foreach ($exportRows as $product) {
                $lines[] = sprintf(
                    '%s | %s | %s | %s | %s | %s | %s',
                    $product->name,
                    $product->category?->name ?? 'Uncategorized',
                    number_format((int) $product->units_sold),
                    number_format((float) $product->revenue, 2, '.', ''),
                    number_format((int) $product->views),
                    $product->is_variant ? 'Variant' : number_format((int) $product->stock_quantity),
                    $product->is_variant ? 'Variants' : ($product->is_active ? 'Active' : 'Inactive')
                );
            }

            return $this->exportPdf('product-report-' . now()->format('Ymd_His') . '.pdf', $lines);
        }

        return view('manage.products.reports.index', compact(
            'stats', 'topSeller', 'mostViewed', 'products', 'search', 'byCategory', 'byBrand'
        ));
    }
}
