<?php

namespace App\Http\Requests\Manage\Products;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => 'required|string|max:255|unique:su_brands,name',
            'description'  => 'nullable|string',
            'logo'         => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:1024', 'dimensions:ratio=2/1',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}
