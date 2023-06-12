<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\File;

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
                    'name' => ['required', 'max:120'],
                    'email' => ['required', 'email', 'unique:companies,email'],
                    'logo' => ['nullable', File::types(['png', 'jpg', 'jpeg'])->max(1024), 'dimensions:min_width=100,min_height=100'],
                    'website' => ['nullable']
                ];
            case 'PUT':
                return [
                    'name' => ['required', 'max:120'],
                    'email' => ['required', 'email', 'unique:companies,email,' . $this->company->id],
                    'logo' => ['nullable', File::types(['png', 'jpg', 'jpeg'])->max(1024), 'dimensions:min_width=100,min_height=100'],
                    'website' => ['nullable']
                ];
        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'success' => false
        ]));
    }
}
