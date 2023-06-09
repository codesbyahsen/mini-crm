<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Jobs\NewCompanyCreationJob;
use App\Http\Requests\CompanyRequest;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $companies = Company::all();
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
                                            <li><a href="javascript:void(0)" data-toggle="modal" data-target="#edit-company-' . $row->id . '"><em class="icon ni ni-repeat"></em><span>Edit</span></a></li>
                                            <li><a href="javascript:void(0)" class="delete-button" data-url="' . route('companies.destroy', $row->id) . '"><em class="icon ni ni-activity-round"></em><span>Delete</span></a></li>
                                        </ul>
                                    </div>
                                </div>';
                    })
                    ->rawColumns(['logo', 'action'])
                    ->make(true);
            }
            $numberOfTotalCompanies = Company::count();
        } catch (ModelNotFoundException $exception) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message', 'The companies are not found'], Response::HTTP_NOT_FOUND);
            }
            return back()->with('error', 'The companies are not found');
        }

        return view('company.index', compact('numberOfTotalCompanies'));
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

            return response()->json(['success' => true, 'message', 'The company created successfully.'], Response::HTTP_OK);
        } catch (QueryException $exception) {
            return response()->json(['success' => false, 'message', 'The database not responed, failed to create company, try again!'], Response::HTTP_INTERNAL_SERVER_ERROR);
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
                $logoName = $company->logo;
            }

            // replace logo value with custom logo name
            $companyDetails = array_replace($request->validated(), array('logo' => $logoName));
            $company->update($companyDetails);
            return response()->json(['success' => true, 'message', 'The company updated successfully.'], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['success' => false, 'message', 'The ' . $request->name . 'you requested to update has not found.'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        try {
            $company->delete();

            return response()->json(['success' => true, 'message', 'The company deleted successfully.'], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['success' => false, 'message', 'The data you requested to delete has not found.'], Response::HTTP_NOT_FOUND);
        }
    }
}
