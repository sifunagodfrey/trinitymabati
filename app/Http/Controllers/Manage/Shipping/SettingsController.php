<?php

namespace App\Http\Controllers\Manage\Shipping;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\Shipping\UpdateShippingSettingsRequest;
use App\Models\Manage\Shipping\ShippingSetting;

class SettingsController extends Controller
{
    // ---------------
    // Display settings form
    // ---------------
    public function index()
    {
        $settings = ShippingSetting::firstOrCreate(
            ['id' => 1],
            [
                'base_rate'               => 130,
                'weight_threshold'        => 5,
                'weight_rate'             => 50,
                'volume_divisor'          => 5000,
                'volume_multiplier'       => 1,
                'distance_rate'           => 10,
                'distance_unit'           => 'km',
                'distance_note'           => '',
                'free_shipping_threshold' => 5000,
                'tracking_enabled'        => false,
            ]
        );

        return view('manage.shipping.settings.index', compact('settings'));
    }

    // ---------------
    // Save settings
    // ---------------
    public function update(UpdateShippingSettingsRequest $request)
    {
        ShippingSetting::where('id', 1)->update([
            'base_rate'               => $request->base_rate,
            'weight_threshold'        => $request->weight_threshold,
            'weight_rate'             => $request->weight_rate,
            'volume_divisor'          => $request->volume_divisor,
            'volume_multiplier'       => $request->volume_multiplier,
            'distance_rate'           => $request->distance_rate,
            'distance_unit'           => 'km',
            'distance_note'           => $request->distance_note,
            'free_shipping_threshold' => $request->free_shipping_threshold,
            'tracking_enabled'        => (bool) $request->input('tracking_enabled', 0),
        ]);

        return redirect()->route('manage.shipping.settings.index')
            ->with('success', 'Shipping settings updated successfully.');
    }
}
