<?php

namespace App\Http\Controllers\Manage\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Manage\Products\ProductReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReviewsController extends Controller
{
    // ---------------
    // List all product reviews with search and status filter
    // ---------------
    public function index(): View
    {
        $query = ProductReview::with(['product', 'user'])
            ->when(request('search'), function ($q) {
                $search = request('search');
                $q->whereHas('product', fn ($p) => $p->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('user', fn ($u) =>
                      $u->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%"));
            })
            ->when(request('status'), fn ($q) => $q->where('status', request('status')));

        $reviews = $query->latest()->paginate(20)->withQueryString();

        return view('manage.ecommerce.reviews.index', compact('reviews'));
    }

    // ---------------
    // Single review detail
    // ---------------
    public function show(string $id): View
    {
        $review = ProductReview::with(['product', 'user'])->findOrFail($id);

        return view('manage.ecommerce.reviews.show', compact('review'));
    }

    // ---------------
    // Approve a pending review
    // ---------------
    public function approve(string $id): RedirectResponse
    {
        ProductReview::findOrFail($id)->update(['status' => 'approved']);

        return redirect()->route('manage.ecommerce.reviews.index')
            ->with('success', 'Review approved successfully.');
    }

    // ---------------
    // Reject a pending review
    // ---------------
    public function reject(string $id): RedirectResponse
    {
        ProductReview::findOrFail($id)->update(['status' => 'rejected']);

        return redirect()->route('manage.ecommerce.reviews.index')
            ->with('success', 'Review rejected.');
    }

    // ---------------
    // Delete a review permanently
    // ---------------
    public function destroy(string $id): RedirectResponse
    {
        ProductReview::findOrFail($id)->delete();

        return redirect()->route('manage.ecommerce.reviews.index')
            ->with('success', 'Review deleted.');
    }
}
