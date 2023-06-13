<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:150'],
            'display_name' => ['string', 'max:150'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone' => ['string', 'max:20'],
            'phone' => ['string', 'max:20'],
            'gender' => ['required', 'string', 'in:Male,Female,Other'],
            'date_of_birth' => ['date'],
            'address_line_one' => ['string', 'max:255'],
            'address_line_two' => ['string', 'max:255'],
            'city' => ['string', 'max:150'],
            'state' => ['string', 'max:150'],
            'country' => ['string', 'max:255'],
        ];
    }
}
