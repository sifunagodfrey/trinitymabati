<?php

namespace App\Http\Requests\Manage\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // --------------- Exclude current brand from unique name check ---------------
        $brandId = $this->route('id');

        return [
            'name'         => 'required|string|max:255|unique:su_brands,name,' . $brandId,
            'description'  => 'nullable|string',
            'logo'         => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:1024',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}
