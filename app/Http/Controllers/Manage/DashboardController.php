<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Manage\Ecommerce\Order;
use App\Models\Manage\Products\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // ---------------
    // Dashboard Index
    // ---------------
    public function index()
    {
        $now = Carbon::now();

        // ---------------
        // Orders Stats
        // ---------------
        $totalOrders    = Order::count();
        $ordersThisWeek = Order::where('created_at', '>=', $now->copy()->subDays(7))->count();
        $ordersLastWeek = Order::whereBetween('created_at', [
            $now->copy()->subDays(14),
            $now->copy()->subDays(7),
        ])->count();
        $ordersWeeklyGrowth = $ordersLastWeek > 0
            ? round((($ordersThisWeek - $ordersLastWeek) / $ordersLastWeek) * 100)
            : ($ordersThisWeek > 0 ? 100 : 0);

        // ---------------
        // Revenue Stats
        // ---------------
        $totalRevenue       = Order::where('payment_status', 'paid')->sum('total');
        $revenueThisMonth   = Order::where('payment_status', 'paid')
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->sum('total');
        $revenueLastMonth   = Order::where('payment_status', 'paid')
            ->whereYear('created_at', $now->copy()->subMonth()->year)
            ->whereMonth('created_at', $now->copy()->subMonth()->month)
            ->sum('total');
        $revenueMonthlyGrowth = $revenueLastMonth > 0
            ? round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100)
            : ($revenueThisMonth > 0 ? 100 : 0);

        // ---------------
        // Customers
        // ---------------
        $totalCustomers = DB::table('su_users')
            ->join('su_user_roles', 'su_user_roles.user_id', '=', 'su_users.id')
            ->join('su_roles', 'su_roles.id', '=', 'su_user_roles.role_id')
            ->where('su_roles.slug', 'customer')
            ->count();

        // ---------------
        // Pending Orders - order awaiting processing OR payment still pending
        // ---------------
        $pendingOrders = Order::where('status', 'pending')
            ->orWhere('payment_status', 'pending')
            ->count();

        // ---------------
        // Products & Stock
        // ---------------
        $totalProducts = Product::count();
        $lowStockCount = Product::where('is_active', true)
            ->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
            ->count();

        // ---------------
        // Recent Orders (last 5)
        // ---------------
        $recentOrders = Order::with('user')->latest()->limit(5)->get();

        // ---------------
        // Low Stock Products (last 5)
        // ---------------
        $lowStockProducts = Product::where('is_active', true)
            ->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
            ->orderBy('stock_quantity')
            ->limit(5)
            ->get();

        // ---------------
        // Twelve-month chart data. Kept server-side so the dashboard works
        // without an external charting dependency.
        // ---------------
        $chartStart = $now->copy()->startOfMonth()->subMonths(11);
        $monthlyRows = Order::query()
            ->where('created_at', '>=', $chartStart)
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as period")
            ->selectRaw('COUNT(*) as order_count')
            ->selectRaw("SUM(CASE WHEN payment_status = 'paid' THEN total ELSE 0 END) as revenue")
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->keyBy('period');

        $salesChart = collect(range(0, 11))->map(function (int $offset) use ($chartStart, $monthlyRows) {
            $month = $chartStart->copy()->addMonths($offset);
            $row = $monthlyRows->get($month->format('Y-m'));

            return [
                'label' => $month->format('M'),
                'revenue' => (float) ($row->revenue ?? 0),
                'orders' => (int) ($row->order_count ?? 0),
            ];
        })->values();

        return view('manage.dashboard.index', compact(
            'totalOrders', 'ordersWeeklyGrowth',
            'totalRevenue', 'revenueMonthlyGrowth',
            'totalCustomers',
            'pendingOrders',
            'totalProducts', 'lowStockCount',
            'recentOrders',
            'lowStockProducts',
            'salesChart'
        ));
    }
}
