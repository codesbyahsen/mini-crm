<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class CompanyRequest extends FormRequest
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
                    'name' => ['required', 'string', 'max:120', 'unique:companies,name'],
                    'email' => ['required', 'string', 'max:120', 'email', 'unique:companies,email'],
                    'logo' => ['nullable', File::types(['png', 'jpg', 'jpeg'])->max(1024), 'dimensions:min_width=100,min_height=100'],
                    'website' => ['nullable'],
                    'password' => ['required', Password::defaults()]
                ];
            case 'PUT':
                return [
                    'name' => ['required', 'string', 'max:120', 'unique:companies,name,' . $this->company->id],
                    'email' => ['required', 'string', 'email', 'max:120', 'unique:companies,email,' . $this->company->id],
                    'logo' => ['nullable', File::types(['png', 'jpg', 'jpeg'])->max(1024), 'dimensions:min_width=100,min_height=100'],
                    'website' => ['nullable']
                ];
            default:
                return [];
        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]));
    }
}
