<?php

namespace App\Http\Requests\Manage\Products;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // --------------- Core Required Fields ---------------
            'name'           => 'required|string|max:255',
            'category_ids'   => 'nullable|array',
            'category_ids.*' => 'integer|exists:su_product_categories,id',
            'selling_price'  => 'required_without:is_variant|nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'currency'       => 'required|in:KES,USD',

            // --------------- Optional Core Fields ---------------
            'brand_id'       => 'nullable|exists:su_brands,id',
            'label_ids'      => 'nullable|array',
            'label_ids.*'    => 'integer|exists:su_product_labels,id',
            'sku'            => 'nullable|string|max:100|unique:su_products,sku',
            'strikethrough_price' => 'nullable|numeric|min:0|gt:selling_price',
            'cost_price'          => 'nullable|numeric|min:0',

            // --------------- Boolean Toggles ---------------
            'is_variant'      => 'boolean',
            'is_vat_exempt'   => 'boolean',
            'is_active'       => 'boolean',

            // --------------- Dimensions & Weight ---------------
            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width'  => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',

            // --------------- Descriptions ---------------
            'short_description'    => 'nullable|string|max:500',
            'detailed_description' => 'nullable|string',

            // --------------- Thumbnail ---------------
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            // --------------- Gallery Images ---------------
            'gallery'          => 'nullable|array',
            'gallery.*'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_library'  => 'nullable|array',
            'gallery_library.*' => 'nullable|string|max:500',

            // --------------- Thumbnail from Media Library ---------------
            'thumbnail_library' => 'nullable|string|max:500',

            // --------------- Variant Images ---------------
            'variants.*.image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            // --------------- Gift Wrapping ---------------

            // --------------- Variants & Attributes ---------------
            'attributes'              => 'nullable|array',
            'attributes.*.name'       => 'required_with:attributes|string|max:100',
            'attributes.*.values'     => 'required_with:attributes|string|max:500',
            'variants'                => 'nullable|array',
            'variants.*.variant_code' => 'nullable|string|max:255',
            'variants.*.sku'          => 'nullable|string|max:100',
            'variants.*.selling_price'       => 'required|numeric|min:0',
            'variants.*.strikethrough_price'  => 'nullable|numeric|min:0',
            'variants.*.cost_price'           => 'nullable|numeric|min:0',
            'variants.*.stock'                => 'nullable|integer|min:0',

            // --------------- Bulk Pricing ---------------
        ];
    }
}
