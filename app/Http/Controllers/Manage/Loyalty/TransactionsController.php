<?php

namespace App\Http\Controllers\Manage\Loyalty;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    // ---------------
    // Full audit log of all loyalty point movements
    // ---------------
    public function index()
    {
        $transactions = DB::table('su_loyalty_transactions as lt')
            ->join('su_users as u', 'u.id', '=', 'lt.user_id')
            ->select(
                'lt.id',
                DB::raw("TRIM(CONCAT(COALESCE(u.first_name,''), ' ', COALESCE(u.last_name,''))) AS user_name"),
                'u.email',
                'lt.type',
                'lt.points',
                'lt.order_id',
                'lt.description',
                'lt.created_at'
            )
            ->orderByDesc('lt.created_at')
            ->paginate(30);

        return view('manage.loyalty.transactions.index', compact('transactions'));
    }
}
