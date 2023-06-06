<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Datatables;

class CompanyController extends Controller
{
    const PATH_COMPANY_LOGO = 'company-logo';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all();
        $numberOfCompanies = Company::count();
        // return Datatables::of($companies)->make();
        return view('company.index', compact('companies', 'numberOfCompanies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $logoName = null;
        if ($request->hasFile('logo')) {
            $logoName = image_upload($request->logo, 100, 100, self::PATH_COMPANY_LOGO, 'logo');
        }

        // replace logo value with custom logo name
        $company = array_replace($request->validated(), array('logo' => $logoName));
        $result = Company::create($company);

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
            $logoName = image_upload($request->logo, 100, 100, self::PATH_COMPANY_LOGO, 'logo');
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
