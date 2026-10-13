<?php

namespace App\Http\Controllers\Manage\Loyalty;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\Loyalty\UpdateLoyaltySettingsRequest;
use App\Models\Manage\Loyalty\LoyaltySetting;

class SettingsController extends Controller
{
    // ---------------
    // Show Loyalty Programme Settings
    // ---------------
    public function index()
    {
        $settings = LoyaltySetting::firstOrCreate(
            ['id' => 1],
            [
                'loyalty_enabled'   => 1,
                'kes_per_point'     => 10.00,
                'redemption_rate'   => 10.00,
                'min_redeem_points' => 100,
            ]
        );

        return view('manage.loyalty.settings.index', compact('settings'));
    }

    // ---------------
    // Save Loyalty Programme Settings
    // ---------------
    public function update(UpdateLoyaltySettingsRequest $request)
    {
        $settings = LoyaltySetting::firstOrCreate(['id' => 1]);

        $settings->update([
            'loyalty_enabled'   => $request->boolean('loyalty_enabled'),
            'kes_per_point'     => $request->kes_per_point,
            'redemption_rate'   => $request->redemption_rate,
            'min_redeem_points' => $request->min_redeem_points,
        ]);

        return redirect()->route('manage.loyalty.settings.index')
            ->with('success', 'Loyalty programme settings updated successfully.');
    }
}
