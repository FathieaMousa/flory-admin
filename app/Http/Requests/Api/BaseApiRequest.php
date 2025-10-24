<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator): void
    {
        $response = response()->json([
            'status' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);

        throw new HttpResponseException($response);
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'required' => 'The :attribute field is required.',
            'email' => 'The :attribute must be a valid email address.',
            'min' => 'The :attribute must be at least :min characters.',
            'max' => 'The :attribute must not exceed :max characters.',
            'unique' => 'The :attribute has already been taken.',
            'numeric' => 'The :attribute must be a number.',
            'integer' => 'The :attribute must be an integer.',
            'boolean' => 'The :attribute must be true or false.',
            'date' => 'The :attribute must be a valid date.',
            'image' => 'The :attribute must be an image file.',
            'mimes' => 'The :attribute must be a file of type: :values.',
            'max:2048' => 'The :attribute must not be larger than 2MB.',
        ];
    }
}
