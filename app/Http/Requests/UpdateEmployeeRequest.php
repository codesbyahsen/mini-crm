<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'first_name' => ['required', 'max:120'],
            'last_name' => ['required', 'max:120'],
            'email' => ['required', 'email', 'unique:employees,email,' . $this->id],
            'phone' => ['nullable'],
            'company_id' => ['required'],
            'project_id' => ['nullable']
        ];
    }

    public function messages(): array
    {
        return [
            'company_id.required' => __('Please mention the company where employee worked.'),
        ];
    }
}
