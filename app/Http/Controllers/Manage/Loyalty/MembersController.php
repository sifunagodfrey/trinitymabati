<?php

namespace App\Http\Controllers\Manage\Loyalty;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MembersController extends Controller
{
    // ---------------
    // Paginated list of all clients with their loyalty balance and tier
    // ---------------
    public function index()
    {
        $members = DB::table('su_loyalty_points as lp')
            ->join('su_users as u', 'u.id', '=', 'lp.user_id')
            ->join('su_loyalty_tiers as t', 't.id', '=', 'lp.tier_id')
            ->select(
                'lp.id',
                'lp.user_id',
                DB::raw("TRIM(CONCAT(COALESCE(u.first_name,''), ' ', COALESCE(u.last_name,''))) AS user_name"),
                'u.email',
                't.name AS tier_name',
                'lp.points_balance',
                'lp.lifetime_points',
                'lp.updated_at'
            )
            ->orderByDesc('lp.lifetime_points')
            ->paginate(25);

        return view('manage.loyalty.members.index', compact('members'));
    }
}
