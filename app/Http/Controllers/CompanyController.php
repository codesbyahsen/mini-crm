<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Notifications\NewCompanyCreation;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all();
        $dt = Datatables::of($companies)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="#" data-toggle="modal" data-target="#edit-company-' . $row->id .'"><em class="icon ni ni-edit"></em><span>Edit</span></a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        $numberOfCompanies = Company::count();
        return view('company.index', compact('numberOfCompanies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $logoName = null;
        if ($request->hasFile('logo')) {
            $logoName = saveResizeImage($request->logo, 'logo', 100, 100);
        }

        // replace logo value with custom logo name
        $company = array_replace($request->validated(), array('logo' => $logoName));
        $result = Company::create($company);

        $message = 'The company {$result->name} has been created.';
        $result->notify(new NewCompanyCreation($message));

        if (!$result) {
            return response()->json(['success' => false, 'message', 'Failed to create company, try again!']);
        }
        return response()->json(['success' => true, 'message', 'The company created successfully.', 'data' => $result], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $logoName = null;
        if ($request->hasFile('logo')) {
            $logoName = saveResizeImage($request->logo, 'logo', 100, 100);
        } else {
            $logoName = $company->logo;
        }

        // replace logo value with custom logo name
        $companyDetails = array_replace($request->validated(), array('logo' => $logoName));
        $result = $company->update($companyDetails);

        if (!$result) {
            return response()->json(['success' => false, 'message', 'Failed to update company, try again!']);
        }
        return response()->json(['success' => true, 'message', 'The company updated successfully.', 'data' => $result], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $result = $company->delete();

        if (!$result) {
            return response()->json(['success' => false, 'message', 'Failed to delete company, try again!']);
        }
        return response()->json(['success' => true, 'message', 'The company deleted successfully.']);
    }
}
