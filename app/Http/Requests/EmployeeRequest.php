<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
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
                    'first_name' => ['required', 'string', 'max:120'],
                    'last_name' => ['required', 'string', 'max:120'],
                    'email' => ['required', 'string', 'email', 'max:150', 'unique:employees,email'],
                    'phone' => ['nullable', 'numeric', 'digits:11'],
                    'company_id' => ['required', 'numeric'],
                    'password' => ['required', Password::defaults()]
                ];
            case 'PUT':
                return [
                    'first_name' => ['required', 'string', 'max:120'],
                    'last_name' => ['required', 'string', 'max:120'],
                    'email' => ['required', 'string', 'email', 'max:150', 'unique:employees,email,' . $this->employee->id],
                    'phone' => ['nullable', 'numeric', 'digits:11'],
                    'company_id' => ['required', 'numeric']
                ];
        }
    }

    public function messages()
    {
        return [
            'company_id.required' => 'The company field is required.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]));
    }
}
