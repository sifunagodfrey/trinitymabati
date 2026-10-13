<?php

namespace App\Http\Requests\Manage\Blogs;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:su_blog_categories,id'],
            'excerpt'     => ['nullable', 'string', 'max:500'],
            'content'     => ['required', 'string'],
            'thumbnail'   => ['nullable', 'image', 'max:2048'],
            'banner'      => ['nullable', 'image', 'max:4096'],
            'tags'        => ['nullable', 'array'],
            'tags.*'      => ['integer', 'exists:su_blog_tags,id'],
            'is_published'=> ['nullable', 'boolean'],
        ];
    }
}
