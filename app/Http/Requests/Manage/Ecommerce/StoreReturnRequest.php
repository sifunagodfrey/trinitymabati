<?php

namespace App\Http\Requests\Manage\Ecommerce;

use Illuminate\Foundation\Http\FormRequest;

class StoreReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // ---------------
            // Order & customer must exist
            // ---------------
            'order_id'   => ['required', 'integer', 'exists:su_orders,id'],
            'user_id'    => ['required', 'integer', 'exists:su_users,id'],
            'product_id' => ['required', 'integer', 'exists:su_products,id'],
            'reason'     => ['required', 'string', 'max:1000'],
            'status'     => ['required', 'in:requested,approved,rejected,refunded'],
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.required'   => 'Please look up and select a valid order.',
            'product_id.required' => 'Please select a product from the order.',
            'reason.required'     => 'A return reason is required.',
        ];
    }
}
