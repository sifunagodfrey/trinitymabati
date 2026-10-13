<?php

namespace App\Http\Requests\Manage\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLabelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // --------------- Exclude current label from unique name check ---------------
        $labelId = $this->route('id');

        return [
            'name'        => 'required|string|max:100|unique:su_product_labels,name,' . $labelId,
            'color_code'  => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'description' => 'nullable|string|max:255',
        ];
    }
}
