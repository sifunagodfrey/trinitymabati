<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class WalletWithdrawRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount'         => 'required|numeric|min:100',
            'method'         => 'required|in:Mpesa,Bank Transfer',
            'phone'          => 'required_if:method,Mpesa|nullable|string|min:9|max:15',
            'account_number' => 'nullable|string|max:50',
            'account_name'   => 'nullable|string|max:100',
            'bank_name'      => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.min'    => 'Minimum withdrawal amount is KES 100.',
            'phone.required_if' => 'A phone number is required for M-Pesa withdrawals.',
        ];
    }
}
