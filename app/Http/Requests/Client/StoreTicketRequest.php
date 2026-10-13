<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subject'    => ['required', 'string', 'max:255'],
            'department' => ['required', 'in:support,billing,marketing,technical,logistics'],
            'urgency'    => ['required', 'in:low,medium,high,critical'],
            'message'    => ['required', 'string'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,docx', 'max:5120'],
        ];
    }
}
