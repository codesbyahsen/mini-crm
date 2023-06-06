<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Actions\FileUpload;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Notifications\NewCompanyCreation;

class CompanyController extends Controller
{
    const PATH_COMPANY_LOGO = 'company-logo';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all();
        // return view();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $logoName = null;
        if ($request->hasFile('logo')) {
            $logoName = FileUpload::handle($request->logo, self::PATH_COMPANY_LOGO, 'logo');
        }

        // replace logo value with custom logo name
        $company = array_replace($request->validated(), array('logo' => $logoName));
        $result = Company::create($company);

        $message = 'The company {$result->name} has been created.';
        $result->notify(new NewCompanyCreation($message));

        if (!$result) {
            return back()->with('error', 'Failed to create company, try again!');
        }
        // return route()->with('success', 'The company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        // return view();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $result = $company->update($request->validated());

        if (!$result) {
            return back()->with('error', 'Failed to update company, try again!');
        }
        // return route()->with('success', 'The company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $result = $company->delete();

        if (!$result) {
            return back()->with('error', 'Failed to delete company, try again!');
        }
        // return route()->with('success', 'The company deleted successfully.');
    }
}
