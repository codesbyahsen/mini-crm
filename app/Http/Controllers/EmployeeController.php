<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with('company')->get();
        // return view();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $result = Employee::create($request->validated());

        if (!$result) {
            return back()->with('error', 'Failed to create employee, try again!');
        }
        // return route()->with('success', 'The employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $result = $employee->update($request->validated());

        if (!$result) {
            return back()->with('error', 'Failed to update employee, try again!');
        }
        // return route()->with('success', 'The employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $result = $employee->delete();

        if (!$result) {
            return back()->with('error', 'Failed to delete employee, try again!');
        }
        // return route()->with('success', 'The employee deleted successfully.');
    }
}
