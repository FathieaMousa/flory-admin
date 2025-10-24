<?php

namespace App\Http\Requests\Api;

class AddressRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'type' => 'required|string|in:home,work,other',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'is_default' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'type' => 'address type',
            'address_line_1' => 'address line 1',
            'address_line_2' => 'address line 2',
            'city' => 'city',
            'state' => 'state',
            'postal_code' => 'postal code',
            'country' => 'country',
            'is_default' => 'default address',
        ];
    }
}
