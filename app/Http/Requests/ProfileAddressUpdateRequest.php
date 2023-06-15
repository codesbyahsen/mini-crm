<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProfileAddressUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'address_line_one' => ['required', 'string', 'max:250'],
            'address_line_two' => ['nullable', 'string', 'max:250'],
            'city' => ['required', 'string', 'max:150'],
            'state' => ['required', 'string', 'max:150'],
            'country' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'address_line_one.required' => 'The address line 1 field is required.',
            'address_line_one.string' => 'The address line 1 field must be a string.',
            'address_line_one.max' => 'The address line 1 field must not be greater than :max characters.',
            'address_line_two.string' => 'The address line 2 field must be a string.',
            'address_line_two.max' => 'The address line 2 field must not be greater than :max characters.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ]));
    }
}
