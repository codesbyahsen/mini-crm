<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        switch (Auth::check()) {
            case Auth::guard('company')->check():
                return [
                    'name' => ['required', 'string', 'max:150'],
                    'display_name' => ['required', 'string', 'max:150'],
                    'phone' => ['required', 'numeric', 'digits:11'],
                    'founded_in' => ['required', 'string', 'max:4'],
                    'website' => ['nullable', 'string'],
                ];
            default:
                return [
                    'first_name' => ['required', 'string', 'max:120'],
                    'last_name' => ['required', 'string', 'max:120'],
                    'display_name' => ['required', 'string', 'max:150'],
                    'phone' => ['nullable', 'numeric', 'digits:11'],
                    'gender' => ['required', 'string', 'in:Male,Female,Other'],
                    'date_of_birth' => ['nullable', 'date'],
                ];
        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ]));
    }
}
