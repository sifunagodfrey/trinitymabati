<?php

namespace App\Http\Requests\Manage\Settings;

use Illuminate\Foundation\Http\FormRequest;

class StoreVatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vat_rate' => 'required|numeric|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'vat_rate.min' => 'VAT rate must be between 0 and 100.',
            'vat_rate.max' => 'VAT rate must be between 0 and 100.',
        ];
    }
}
