<?php

namespace App\Http\Requests\Manage\Blogs;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:120'],
            'slug'        => ['nullable', 'string', 'max:150', 'unique:su_blog_categories,slug'],
            'description' => ['nullable', 'string', 'max:1000'],
            'banner'      => ['nullable', 'image', 'max:4096'],
        ];
    }
}
