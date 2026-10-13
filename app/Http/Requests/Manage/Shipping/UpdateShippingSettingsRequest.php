<?php

namespace App\Http\Requests\Manage\Shipping;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShippingSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'base_rate'               => 'required|numeric|min:0',
            'weight_threshold'        => 'nullable|numeric|min:0',
            'weight_rate'             => 'nullable|numeric|min:0',
            'volume_divisor'          => 'nullable|numeric|min:1',
            'volume_multiplier'       => 'nullable|numeric|min:0',
            'distance_rate'           => 'nullable|numeric|min:0',
            'distance_note'           => 'nullable|string|max:500',
            'free_shipping_threshold' => 'nullable|numeric|min:0',
            'tracking_enabled'        => 'nullable|in:0,1',
        ];
    }
}
