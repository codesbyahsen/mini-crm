<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employees = Employee::with('company')->get();
        if ($request->ajax()) {
            return Datatables::of($employees)
                ->addIndexColumn()
                ->editColumn('fullname', function ($row) {
                    return $row->fullName();
                })
                ->addColumn('action', function ($row) {

                    return '<div class="drodown">
                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="javascript:void(0)" data-toggle="modal" class="edit-btn" data-id="' . $row->id . '" data-target="#edit-employee-' . $row->id . '"><em class="icon ni ni-repeat"></em><span>Edit</span></a></li>
                                        <li><a href="javascript:void(0)" class="delete-button" data-url="' . route('employees.destroy', $row->id) . '"><em class="icon ni ni-activity-round"></em><span>Delete</span></a></li>
                                    </ul>
                                </div>
                            </div>';
                })
                ->rawColumns(['fullname', 'action'])
                ->make(true);
        }
        $numberOfTotalEmployees = Employee::count();
        $companies = Company::get(['id', 'name']);
        return view('employee.index', compact('employees', 'numberOfTotalEmployees', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        try {
            Employee::create($request->validated());

            return response()->json(['success' => true, 'message', 'The employee created successfully.'], 200);
        } catch (QueryException $exception) {
            return response()->json(['success' => false, 'message', $exception->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        try {
            $employee->update($request->validated());
            return response()->json(['success' => true, 'message', 'The employee updated successfully.'], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['success' => false, 'message', $exception->getMessage()], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();

            return response()->json(['success' => true, 'message', 'The employee deleted successfully.']);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['success' => false, 'message', $exception->getMessage()], 404);
        }
    }
}
