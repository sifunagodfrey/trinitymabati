<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreReplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reply_message' => ['required', 'string'],
            'attachment'    => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,docx', 'max:5120'],
        ];
    }
}
