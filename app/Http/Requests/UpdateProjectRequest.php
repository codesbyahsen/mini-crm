<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'name' => ['required', 'max:220'],
            'detail' => ['nullable', 'max:10000'],
            'client' => ['required', 'max:120', Rule::unique('projects')->ignore($this->id)->where('name', $this->name)],
            'total_cost' => ['required', 'max:40'],
            'deadline' => ['required', 'date'],
            'user_id' => ['nullable']
        ];
    }

    public function messages(): array
    {
        return [
            'client.required' => __('The client name is required.'),
            'client.max' => __('The client name must not be greater than :max numbers.')
        ];
    }
}
