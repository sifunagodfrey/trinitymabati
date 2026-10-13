<?php

/* -------------------
   Client dashboard. Summary cards and recent activity built from raw DB
   queries so it does not depend on stub model classes. Wallet and
   loyalty were removed from the platform, so this only reads order data.
------------------- */

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // ---------------
    // Client dashboard - summary cards + recent activity.
    // ---------------
    public function index()
    {
        $userId = Auth::id();

        // ---------------
        // Summary card data
        // ---------------
        $orderCount = DB::table('su_orders')
            ->where('user_id', $userId)
            ->count();

        // ---------------
        // Recent activity
        // ---------------
        $recentOrders = DB::table('su_orders')
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get(['id', 'order_code', 'status', 'payment_status', 'total', 'created_at']);

        return view('client.dashboard.index', compact(
            'orderCount',
            'recentOrders'
        ));
    }
}
