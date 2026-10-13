<?php

namespace App\Http\Requests\Manage\Shipping;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationPricingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'county_id'          => 'required|exists:su_counties,id',
            'location_name'      => 'required|string|max:255',
            'price'              => 'required|numeric|min:0',
            'distance'           => 'nullable|numeric|min:0',
            'estimated_delivery' => 'nullable|integer|min:1',
        ];
    }
}
