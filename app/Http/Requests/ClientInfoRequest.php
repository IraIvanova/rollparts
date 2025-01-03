<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|required|max:255', // Only letters and spaces
            'lastName' => 'string|required|max:255', // Only letters and spaces
            'phone' => 'string|required', // International format, 7-15 digits
            'email' => 'string|required|email|max:255',
            'country' => 'string|required|max:100', // Limit country name length
            'city' => 'string|required|max:100',
            'address' => 'string|required|max:500', // Longer limit for detailed addresses
            'zip' => 'string|required|regex:/^\d{4,10}$/', // Numeric zip code, 4-10 digits
            'additionalNotes' => 'string|nullable|max:1000', // Optional, limit length
        ];
    }
}
