<?php

namespace App\Http\Requests\Manage\Loyalty;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLoyaltySettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'loyalty_enabled'  => 'boolean',
            'kes_per_point'    => 'required|numeric|min:1',
            'redemption_rate'  => 'required|numeric|min:1',
            'min_redeem_points' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'kes_per_point.min'     => 'KES per point must be at least 1.',
            'redemption_rate.min'   => 'Redemption rate must be at least 1.',
            'min_redeem_points.min' => 'Minimum redeemable points must be at least 1.',
        ];
    }
}
