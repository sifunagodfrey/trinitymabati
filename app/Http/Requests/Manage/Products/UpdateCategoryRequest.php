<?php

namespace App\Http\Requests\Manage\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // --------------- Exclude current category from unique name check ---------------
        $categoryId = $this->route('id');

        return [
            'name'            => 'required|string|max:255|unique:su_product_categories,name,' . $categoryId,
            'parent_id'       => 'nullable|exists:su_product_categories,id',
            'description'     => 'nullable|string',
            'icon'            => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:1024',
            'featured_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}
