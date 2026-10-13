<?php

namespace App\Http\Requests\Manage\Tickets;

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
            'user_id'    => ['required', 'integer', 'exists:su_users,id'],
            'subject'    => ['required', 'string', 'max:255'],
            'department' => ['required', 'in:support,billing,marketing,technical,logistics'],
            'urgency'    => ['required', 'in:low,medium,high,critical'],
            'message'    => ['required', 'string'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,docx', 'max:5120'],
        ];
    }
}
