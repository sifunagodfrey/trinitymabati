<?php

namespace App\Http\Requests\Manage\Blogs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlogCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name'        => ['required', 'string', 'max:120'],
            'slug'        => ['nullable', 'string', 'max:150', Rule::unique('su_blog_categories', 'slug')->ignore($id)],
            'description' => ['nullable', 'string', 'max:1000'],
            'banner'      => ['nullable', 'image', 'max:4096'],
        ];
    }
}
