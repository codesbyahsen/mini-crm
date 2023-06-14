<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProjectRequest;
use App\Models\Employee;
use App\Traits\AjaxResponse;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class ProjectController extends Controller
{
    use AjaxResponse;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $projects = Project::get();
        if ($request->ajax()) {
            return Datatables::of($projects)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    return '<div class="drodown">
                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="javascript:void(0)" data-toggle="modal" class="view-details-button" data-url="' . route('projects.show', $row->id) . '" data-update-url="' . route('projects.update', $row->id) . '" data-target="#edit-project"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                        <li><a href="javascript:void(0)" data-toggle="modal" class="edit-button" data-url="' . route('projects.edit', $row->id) . '" data-update-url="' . route('projects.update', $row->id) . '" data-target="#edit-project"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                                        <li><a href="javascript:void(0)" class="delete-button" data-url="' . route('projects.destroy', $row->id) . '"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
                                    </ul>
                                </div>
                            </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $employees = Employee::get(['id', 'first_name', 'last_name']);

        return view('project.index', compact('employees'));
    }

    /**
     * Display total number of projects.
     */
    public function totalProjects()
    {
        $numberOfTotalProjects = Project::count();
        return $this->success('The total projects fetched successfully.', $numberOfTotalProjects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        try {
            $project = Project::create($request->validated());

            if ($request->employee_id) {
                $this->assignProjectTo($project->id, $request->employee_id);
            }
            return $this->success('The project created successfully.', Response::HTTP_CREATED);
        } catch (QueryException $exception) {
            return $this->error('failed_query', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function assignProjectTo(string $projectId, array $employeeIds): void
    {
        foreach ($employeeIds as $employeeId) {
            DB::table('employee_project')->updateOrInsert(
                ['project_id' => $projectId, 'employee_id' => $employeeId],
                ['project_id' => $projectId, 'employee_id' => $employeeId, 'created_at' => now(), 'updated_at' => now()]
            );
        }
        DB::table('employee_project')->whereNotIn('employee_id', $employeeIds)->where('project_id', $projectId)->delete();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $project = Project::whereId($id)->with('employees')->first();
            return $this->success('The project against id: ' . $id . ' fetched successfully.', $project);
        } catch (ModelNotFoundException $exception) {
            return $this->error('not_found', Response::HTTP_NOT_FOUND);
        }
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
            return $this->success('The project updated successfully.');
        } catch (ModelNotFoundException $exception) {
            return $this->error('not_found_update', Response::HTTP_NOT_FOUND);
        } catch (QueryException $exception) {
            return $this->error('failed_query', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            $project->delete();

            return $this->success('The project deleted successfully.');
        } catch (ModelNotFoundException $exception) {
            return $this->error('not_found_delete', Response::HTTP_NOT_FOUND);
        }
    }
}
