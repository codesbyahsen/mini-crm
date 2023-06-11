<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProjectRequest extends FormRequest
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
                    'name' => ['required', 'max:220'],
                    'detail' => ['nullable', 'max:10000'],
                    'client_name' => ['required', 'max:120', Rule::unique('projects')->where('name', $this->name)],
                    'total_cost' => ['required', 'max:40'],
                    'deadline' => ['required', 'date'],
                    'employee_id' => ['nullable']
                ];
            case 'PUT':
                return [
                    'name' => ['required', 'max:220'],
                    'detail' => ['nullable', 'max:10000'],
                    'client_name' => ['required', 'max:120', Rule::unique('projects')->ignore($this->id)->where('name', $this->name)],
                    'total_cost' => ['required', 'max:40'],
                    'deadline' => ['required', 'date'],
                    'employee_id' => ['nullable']
                ];
            default:
                return [];
        }
    }

    public function messages(): array
    {
        return [
            'client_name.required' => __('The client name is required.'),
            'client_name.max' => __('The client name must not be greater than :max numbers.'),
            'client_name.unique' => __('The :attribute has already been taken for ' . $this->name . '.')
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
