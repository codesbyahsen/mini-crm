<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;
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

        if ($result && !empty($result)) {
            $this->assignEmployeeTo($request->project_id, $result->id);
        }

        if (!$result) {
            return back()->with('error', 'Failed to create employee, try again!');
        }
        // return route()->with('success', 'The employee created successfully.');
    }

    private function assignEmployeeTo(array $projectIds, string $employeeId)
    {
        foreach ($projectIds as $projectId) {
            DB::table('project_employee')->updateOrInsert(
                ['project_id' => $projectId, 'employee_id' => $employeeId],
                ['project_id' => $projectId, 'employee_id' => $employeeId, 'created_at' => now(), 'updated_at' => now()]
            );
        }
        DB::table('project_employee')->whereNotIn('project_id', $projectIds)->where('employee_id', $employeeId)->delete();
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
