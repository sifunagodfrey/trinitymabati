<?php

namespace App\Http\Controllers\Manage\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Manage\Ecommerce\AbandonedCart;
use App\Models\Manage\Ecommerce\AbandonedCartLog;
use Illuminate\View\View;

class AbandonedCartsController extends Controller
{
    // ---------------
    // Paginated list of all abandoned carts with search and filter
    // ---------------
    public function index(): View
    {
        $query = AbandonedCart::with('user')->latest();

        if (request('search')) {
            $search = request('search');
            $query->whereHas('user', function ($u) use ($search) {
                $u->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name',  'like', "%{$search}%")
                  ->orWhere('email',      'like', "%{$search}%");
            });
        }

        if (request('recovered') !== null && request('recovered') !== '') {
            $query->where('recovered', (bool) request('recovered'));
        }

        $carts = $query->paginate(20)->withQueryString();

        return view('manage.ecommerce.abandoned-carts.index', compact('carts'));
    }

    // ---------------
    // Single abandoned cart detail with product logs
    // ---------------
    public function show(string $id): View
    {
        $cart = AbandonedCart::with('user')->findOrFail($id);

        $logs = AbandonedCartLog::with('product')
            ->where('user_id', $cart->user_id)
            ->orderByDesc('sent_at')
            ->get();

        return view('manage.ecommerce.abandoned-carts.show', compact('cart', 'logs'));
    }

    // ---------------
    // Mark an abandoned cart as recovered (admin action)
    // ---------------
    public function markRecovered(string $id): \Illuminate\Http\RedirectResponse
    {
        $cart = AbandonedCart::findOrFail($id);
        $cart->update(['recovered' => true]);

        return redirect()
            ->route('manage.ecommerce.abandoned-carts.show', $id)
            ->with('success', 'Cart marked as recovered.');
    }
}
