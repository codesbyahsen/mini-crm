<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisteredEmployeeController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . Employee::class],
            'company_id' => ['required', 'string', 'max:120'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'company_id.required' => 'The company field is required.',
            'company_id.string' => 'The company field must be a string.',
            'company_id.max' => 'The company field must be not be greater than :max characters.'
        ]);

        $employee = Employee::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'company_id' => $request->company_id,
            'password' => Hash::make($request->password),
        ]);
        $employee->assignRole('employee');

        event(new Registered($employee));

        Auth::guard('employee')->login($employee);

        return redirect(RouteServiceProvider::HOME);
    }
}
