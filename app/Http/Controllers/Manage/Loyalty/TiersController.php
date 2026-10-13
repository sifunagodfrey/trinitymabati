<?php

namespace App\Http\Controllers\Manage\Loyalty;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\Loyalty\UpdateLoyaltyTierRequest;
use App\Models\Manage\Loyalty\LoyaltyTier;

class TiersController extends Controller
{
    // ---------------
    // List All Loyalty Tiers
    // ---------------
    public function index()
    {
        $tiers = LoyaltyTier::orderBy('min_points')->get();

        return view('manage.loyalty.tiers.index', compact('tiers'));
    }

    // ---------------
    // Edit Tier Form
    // ---------------
    public function edit(int $id)
    {
        $tier = LoyaltyTier::findOrFail($id);

        return view('manage.loyalty.tiers.edit', compact('tier'));
    }

    // ---------------
    // Save Tier Changes
    // ---------------
    public function update(UpdateLoyaltyTierRequest $request, int $id)
    {
        $tier = LoyaltyTier::findOrFail($id);

        $tier->update([
            'name'              => $request->name,
            'min_points'        => $request->min_points,
            'discount_percent'  => $request->discount_percent,
            'points_multiplier' => $request->points_multiplier,
            'badge_icon'        => $request->badge_icon,
            'is_active'         => $request->boolean('is_active'),
        ]);

        return redirect()->route('manage.loyalty.tiers.index')
            ->with('success', "Tier \"{$tier->name}\" updated successfully.");
    }
}
