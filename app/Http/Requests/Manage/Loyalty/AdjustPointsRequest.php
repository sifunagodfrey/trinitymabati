<?php

namespace App\Http\Requests\Manage\Loyalty;

use Illuminate\Foundation\Http\FormRequest;

class AdjustPointsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'         => 'required|integer|exists:su_users,id',
            'adjustment_type' => 'required|in:add,deduct',
            'points'          => 'required|integer|min:1',
            'description'     => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.exists'  => 'The selected user does not exist.',
            'points.min'      => 'Points must be at least 1.',
        ];
    }
}
