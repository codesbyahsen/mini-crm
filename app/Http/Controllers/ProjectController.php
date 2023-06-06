<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('employees')->get();
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
    public function store(StoreProjectRequest $request)
    {
        $result = Project::create($request->validated());

        if ($result && !empty($result)) {
            $this->assignProjectTo($result->id, $request->employee_id);
        }

        if (!$result) {
            return back()->with('error', 'Failed to create project, try again!');
        }
        // return route()->with('success', 'The project created successfully.');
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
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $result = $project->update($request->validated());

        if ($result && !empty($result)) {
            $this->assignProjectTo($project->id, $request->employee_id);
        }

        if (!$result) {
            return back()->with('error', 'Failed to update project, try again!');
        }
        // return route()->with('success', 'The project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $result = $project->delete();

        if (!$result) {
            return back()->with('error', 'Failed to delete project, try again!');
        }
        // return route()->with('success', 'The project deleted successfully.');
    }
}
