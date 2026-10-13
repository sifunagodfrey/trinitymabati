<?php

/* -------------------
   Admin coupon code management - list, create, edit, toggle and delete
   promotional discount codes stored in su_discounts.
------------------- */

namespace App\Http\Controllers\Manage\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Manage\Products\Coupon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class CouponsController extends Controller
{
    // ---------------
    // List all coupon codes with search and status filter
    // ---------------
    public function index(): View
    {
        $query = Coupon::when(request('search'), fn ($q) =>
                $q->where('code', 'like', '%' . request('search') . '%'))
            ->when(request('status'), fn ($q) => $q->where('status', request('status')));

        $coupons = $query->orderByDesc('id')->paginate(20)->withQueryString();

        return view('manage.ecommerce.coupons.index', compact('coupons'));
    }

    // ---------------
    // Show create coupon form
    // ---------------
    public function create(): View
    {
        return view('manage.ecommerce.coupons.create');
    }

    // ---------------
    // Store a new coupon code
    // ---------------
    public function store(Request $request): RedirectResponse
    {
        $this->validateCoupon($request);

        $code = $request->filled('code')
            ? strtoupper(trim($request->code))
            : 'NAW' . strtoupper(substr(uniqid(), -6));

        if (Coupon::where('code', $code)->exists()) {
            return back()->withInput()
                ->withErrors(['code' => 'This coupon code already exists.']);
        }

        Coupon::create([
            'code'          => $code,
            'discount_type' => $request->discount_type,
            'value'         => $request->value,
            'usage_limit'   => $request->usage_limit ?? 1,
            'used_count'    => 0,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'status'        => 'active',
            'created_at'    => now(),
        ]);

        return redirect()->route('manage.ecommerce.coupons.index')
            ->with('success', 'Coupon code "' . $code . '" created successfully.');
    }

    // ---------------
    // Show edit coupon form
    // ---------------
    public function edit(string $id): View
    {
        $coupon = Coupon::findOrFail($id);

        return view('manage.ecommerce.coupons.edit', compact('coupon'));
    }

    // ---------------
    // Update an existing coupon code
    // ---------------
    public function update(Request $request, string $id): RedirectResponse
    {
        $coupon = Coupon::findOrFail($id);

        $this->validateCoupon($request);

        $code = strtoupper(trim($request->code ?: $coupon->code));

        if (Coupon::where('code', $code)->where('id', '<>', $coupon->id)->exists()) {
            return back()->withInput()
                ->withErrors(['code' => 'This coupon code already exists.']);
        }

        $coupon->update([
            'code'          => $code,
            'discount_type' => $request->discount_type,
            'value'         => $request->value,
            'usage_limit'   => $request->usage_limit,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
        ]);

        return redirect()->route('manage.ecommerce.coupons.index')
            ->with('success', 'Coupon code "' . $code . '" updated successfully.');
    }

    // ---------------
    // Toggle coupon between active and inactive
    // ---------------
    public function toggleStatus(string $id): RedirectResponse
    {
        $coupon    = Coupon::findOrFail($id);
        $newStatus = $coupon->status === 'active' ? 'inactive' : 'active';
        $coupon->update(['status' => $newStatus]);

        return redirect()->route('manage.ecommerce.coupons.index')
            ->with('success', 'Coupon status updated.');
    }

    // ---------------
    // Delete a coupon permanently
    // ---------------
    public function destroy(string $id): RedirectResponse
    {
        Coupon::findOrFail($id)->delete();

        return redirect()->route('manage.ecommerce.coupons.index')
            ->with('success', 'Coupon deleted.');
    }

    // ---------------
    // Shared validation rules
    // ---------------
    private function validateCoupon(Request $request): void
    {
        Validator::make($request->all(), [
            'code'          => 'nullable|string|max:32|regex:/^[A-Za-z0-9_-]+$/',
            'discount_type' => 'required|in:fixed,percent',
            'value'         => 'required|numeric|min:0.01',
            'usage_limit'   => 'nullable|integer|min:1',
            'start_date'    => 'nullable|date',
            'end_date'      => 'required|date|after_or_equal:start_date',
        ])->validate();
    }
}
