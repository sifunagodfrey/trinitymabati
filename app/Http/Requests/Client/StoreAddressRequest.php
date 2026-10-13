<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAddressRequest extends FormRequest
{
    // ---------------
    // Authorisation
    // ---------------
    public function authorize(): bool
    {
        return true;
    }

    // ---------------
    // Validation Rules
    // ---------------
    public function rules(): array
    {
        return [
            'county_id' => [
                'required',
                'integer',
                Rule::exists('su_counties', 'id'),
            ],

            'location_id' => [
                'required',
                'integer',
                // Must belong to the selected county
                Rule::exists('su_towns', 'id')->where('county_id', $this->input('county_id')),
            ],
        ];
    }

    // ---------------
    // Custom Messages
    // ---------------
    public function messages(): array
    {
        return [
            'county_id.required'   => 'Please select a county.',
            'county_id.exists'     => 'The selected county is invalid.',
            'location_id.required' => 'Please select a delivery location.',
            'location_id.exists'   => 'The selected location does not belong to the chosen county.',
        ];
    }
}
