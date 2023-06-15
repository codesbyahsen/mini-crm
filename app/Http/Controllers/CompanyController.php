<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Jobs\NewCompanyCreationJob;
use App\Http\Requests\CompanyRequest;
use App\Traits\AjaxResponse;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends Controller
{
    use AjaxResponse;

    public function __construct()
    {
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companies = Company::all();
        if ($request->ajax()) {
            return Datatables::of($companies)
                ->addIndexColumn()
                ->editColumn('logo', function ($row) {
                    return '<div class="user-avatar bg-light"><img src=' . $row->logo . ' \/></div>';
                })
                ->addColumn('action', function ($row) {

                    return '<div class="drodown">
                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="javascript:void(0)" class="edit-button" data-url="' . route('companies.edit', $row->id) . '" data-update-url="' . route('companies.update', $row->id) . '" data-toggle="modal" data-target="#edit-company"><em class="icon ni ni-repeat"></em><span>Edit</span></a></li>
                                        <li><a href="javascript:void(0)" class="delete-button" data-url="' . route('companies.destroy', $row->id) . '"><em class="icon ni ni-activity-round"></em><span>Delete</span></a></li>
                                    </ul>
                                </div>
                            </div>';
                })
                ->rawColumns(['logo', 'action'])
                ->make(true);
        }

        return view('company.index');
    }

    /**
     * Display total number of companies.
     */
    public function totalCompanies()
    {
        $numberOfTotalCompanies = Company::count();
        return $this->success('The total companies fetched successfully.', $numberOfTotalCompanies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyRequest $request)
    {
        try {
            $logoName = null;
            if ($request->hasFile('logo')) {
                $logoName = saveResizeImage($request->logo, 'logo', 100, 100);
            }

            // replace logo value with custom logo name
            $company = array_replace($request->validated(), array('logo' => $logoName));
            $result = Company::create($company);

            dispatch(new NewCompanyCreationJob($result, 'The company ' . $result->name . ' has been created.'));

            return $this->success('The company created successfully.', $result, Response::HTTP_CREATED);
        } catch (QueryException $exception) {
            return $this->error('failed_query', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        try {
            return $this->success('The company against id: ' . $company->id . ' fetched successfully.', $company);
        } catch (ModelNotFoundException $exception) {
            return $this->error('not_found', Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyRequest $request, Company $company)
    {
        try {
            $logoName = null;
            if ($request->hasFile('logo')) {
                $logoName = saveResizeImage($request->logo, 'logo', 100, 100);
            } else {
                $logoName = $company->getAttributes()['logo'];
            }

            // replace logo value with custom logo name
            $companyDetails = array_replace($request->validated(), array('logo' => $logoName));
            $company->update($companyDetails);
            return $this->success('The company updated successfully.');
        } catch (ModelNotFoundException $exception) {
            return $this->error('not_found_update', Response::HTTP_NOT_FOUND);
        } catch (QueryException $exception) {
            return $this->error('failed_query', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        try {
            $company->delete();

            return $this->success('The company deleted successfully.');
        } catch (ModelNotFoundException $exception) {
            return $this->error('not_found_delete', Response::HTTP_NOT_FOUND);
        }
    }
}
