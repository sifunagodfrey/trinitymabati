<?php

namespace App\Http\Controllers\Manage\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class VatOrdersController extends Controller
{
    // ---------------
    // List completed orders with VAT-eligible items and calculated VAT totals
    // ---------------
    public function index(): View
    {
        $vatRate = (float) (DB::table('su_vat')
            ->where('is_active', 1)
            ->orderByDesc('id')
            ->value('rate') ?? 0.0);

        $search        = request('search');
        $paymentStatus = request('payment_status');
        $startDate     = request('start_date');
        $endDate       = request('end_date');

        $query = DB::table('su_orders as o')
            ->join('su_users as u', 'o.user_id', '=', 'u.id')
            ->join('su_order_items as oi', 'oi.order_id', '=', 'o.id')
            ->join('su_products as p', 'oi.product_id', '=', 'p.id')
            ->where('o.status', 'completed')
            ->where('p.is_vat_exempt', 0)
            ->select([
                'o.id',
                'o.order_code',
                'o.total',
                'o.currency',
                'o.created_at',
                'o.payment_status',
                'o.status',
                'u.first_name',
                'u.last_name',
                DB::raw("SUM(CASE WHEN p.is_vat_exempt = 0
                    THEN (oi.price * oi.quantity * ({$vatRate} / 100))
                    ELSE 0 END) as vat_amount"),
            ])
            ->groupBy('o.id', 'o.order_code', 'o.total', 'o.currency',
                      'o.created_at', 'o.payment_status', 'o.status',
                      'u.first_name', 'u.last_name');

        if ($search) {
            $query->where('o.order_code', 'like', "%{$search}%");
        }

        if ($paymentStatus) {
            $query->where('o.payment_status', $paymentStatus);
        }

        if ($startDate) {
            $query->where('o.created_at', '>=', $startDate . ' 00:00:00');
        }

        if ($endDate) {
            $query->where('o.created_at', '<=', $endDate . ' 23:59:59');
        }

        $orders = $query->orderByDesc('o.created_at')->paginate(20)->withQueryString();

        return view('manage.ecommerce.vat-orders.index', compact(
            'orders', 'vatRate', 'search', 'paymentStatus', 'startDate', 'endDate'
        ));
    }
}
