<?php

namespace App\Http\Requests\Manage\Loyalty;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLoyaltyTierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'              => 'required|string|max:50',
            'min_points'        => 'required|integer|min:0',
            'discount_percent'  => 'required|numeric|min:0|max:100',
            'points_multiplier' => 'required|numeric|min:0.1|max:10',
            'badge_icon'        => 'nullable|string|max:100',
            'is_active'         => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'points_multiplier.min' => 'Points multiplier must be at least 0.1.',
            'points_multiplier.max' => 'Points multiplier cannot exceed 10.',
            'discount_percent.max'  => 'Discount cannot exceed 100%.',
        ];
    }
}
