<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use App\Traits\AjaxResponse;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    use AjaxResponse;

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
                                        <li><a href="javascript:void(0)" data-toggle="modal" class="edit-button" data-url="' . route('employees.edit', $row->id) . '" data-update-url="' . route('employees.update', $row->id) . '"><em class="icon ni ni-repeat"></em><span>Edit</span></a></li>
                                        <li><a href="javascript:void(0)" class="delete-button" data-url="' . route('employees.destroy', $row->id) . '"><em class="icon ni ni-activity-round"></em><span>Delete</span></a></li>
                                    </ul>
                                </div>
                            </div>';
                })
                ->rawColumns(['fullname', 'action'])
                ->make(true);
        }

        $companies = Company::get(['id', 'name']);
        return view('employee.index', compact('companies'));
    }

    /**
     * Display total number of employees.
     */
    public function totalEmployees()
    {
        $numberOfTotalEmployees = Employee::count();
        return $this->success('The total employees fetched successfully.', $numberOfTotalEmployees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        try {
            $employee = Employee::create($request->validated());

            return $this->success('The employee created successfully.', $employee, Response::HTTP_CREATED);
        } catch (QueryException $exception) {
            return $this->error('failed_query', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $employee = Employee::whereId($id)->with('company')->first();
            return $this->success('The employee against id: ' . $id . ' fetched successfully.', $employee);
        } catch (ModelNotFoundException $exception) {
            return $this->error('not_found', Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        try {
            $employee->update($request->validated());
            return $this->success('The employee updated successfully.');
        } catch (ModelNotFoundException $exception) {
            return $this->error('not_found_update', Response::HTTP_NOT_FOUND);
        } catch (QueryException $exception) {
            return $this->error('failed_query', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();

            return $this->success('The employee deleted successfully.');
        } catch (ModelNotFoundException $exception) {
            return $this->error('not_found_delete', Response::HTTP_NOT_FOUND);
        }
    }
}
