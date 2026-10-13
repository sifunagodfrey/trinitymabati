<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class WalletTopupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount'  => 'required|numeric|min:10|max:300000',
            'phone'   => 'required|string|min:9|max:15',
            'gateway' => 'required|in:mpesa,coopbank',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.min' => 'Minimum top-up amount is KES 10.',
            'amount.max' => 'Maximum top-up amount is KES 300,000.',
            'gateway.in' => 'Please select a valid payment method.',
        ];
    }
}
