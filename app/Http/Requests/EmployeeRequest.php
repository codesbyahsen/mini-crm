<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EmployeeRequest extends FormRequest
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
        switch ($this->getMethod()) {
            case 'POST':
                return [
                    'first_name' => ['required', 'max:120'],
                    'last_name' => ['required', 'max:120'],
                    'email' => ['nullable', 'email', 'unique:employees,email'],
                    'phone' => ['nullable'],
                    'company_id' => ['nullable']
                ];
            case 'PUT':
                return [
                    'first_name' => ['required', 'max:120'],
                    'last_name' => ['required', 'max:120'],
                    'email' => ['nullable', 'email', 'unique:employees,email,' . $this->id],
                    'phone' => ['nullable'],
                    'company_id' => ['nullable']
                ];
        }
    }

    public function messages(): array
    {
        return [
            'company_id.required' => __('Please mention the company where employee worked.'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'status' => false
        ]));
    }
}
