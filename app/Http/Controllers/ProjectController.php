<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProjectRequest;
use App\Models\Employee;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $projects = Project::get();
            if ($request->ajax()) {
                return Datatables::of($projects)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {

                        return '<div class="drodown">
                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <ul class="link-list-opt no-bdr">
                                            <li><a href="javascript:void(0)" data-toggle="modal" class="edit-btn" data-id="' . $row->id . '" data-target="#edit-project-' . $row->id . '"><em class="icon ni ni-repeat"></em><span>Edit</span></a></li>
                                            <li><a href="javascript:void(0)" class="delete-button" data-url="' . route('projects.destroy', $row->id) . '"><em class="icon ni ni-activity-round"></em><span>Delete</span></a></li>
                                        </ul>
                                    </div>
                                </div>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            $employees = Employee::get(['id', 'first_name', 'last_name']);
            $numberOfTotalProjects = Project::count();
        } catch (ModelNotFoundException $exception) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message', 'The projects are not found'], Response::HTTP_NOT_FOUND);
            }
            return back()->with('error', 'The projects are not found');
        }

        return view('project.index', compact('employees', 'numberOfTotalProjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        try {
            $project = Project::create($request->validated());

            if ($request->employee_id && count($request->employee_id) > 0) {
                $this->assignProjectTo($project->id, $request->employee_id);
            }
            return response()->json(['success' => true, 'message', 'The project created successfully.'], Response::HTTP_OK);
        } catch (QueryException $exception) {
            return response()->json(['success' => false, 'message', 'The database not responed, failed to create project, try again!'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function assignProjectTo(string $projectId, array $employeeIds): void
    {
        foreach ($employeeIds as $employeeId) {
            DB::table('project_employee')->updateOrInsert(
                ['project_id' => $projectId, 'employee_id' => $employeeId],
                ['project_id' => $projectId, 'employee_id' => $employeeId, 'created_at' => now(), 'updated_at' => now()]
            );
        }
        DB::table('project_employee')->whereNotIn('employee_id', $employeeIds)->where('project_id', $projectId)->delete();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, Project $project)
    {
        try {
            $project->update($request->validated());

            if ($request->employee_id && count($request->employee_id) > 0) {
                $this->assignProjectTo($project->id, $request->employee_id);
            }
            return response()->json(['success' => true, 'message', 'The project updated successfully.'], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['success' => false, 'message', 'The ' . $request->name . 'you requested to update has not found.'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            $project->delete();

            return response()->json(['success' => true, 'message', 'The project deleted successfully.'], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['success' => false, 'message', 'The data you requested to delete has not found.'], Response::HTTP_NOT_FOUND);
        }
    }
}
