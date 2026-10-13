<?php

namespace App\Http\Controllers\Manage\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Manage\Products\FlashSale;
use Illuminate\View\View;

class FlashSalesController extends Controller
{
    // ---------------
    // List all flash sale campaigns with product and status filter
    // ---------------
    public function index(): View
    {
        $query = FlashSale::with('product')
            ->when(request('search'), fn ($q) =>
                $q->whereHas('product', fn ($p) =>
                    $p->where('name', 'like', '%' . request('search') . '%')))
            ->when(request('status'), fn ($q) => $q->where('status', request('status')));

        $flashSales = $query->latest()->paginate(20)->withQueryString();

        return view('manage.ecommerce.flash-sales.index', compact('flashSales'));
    }
}
