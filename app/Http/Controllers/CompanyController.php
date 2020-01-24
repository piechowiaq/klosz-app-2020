<?php

namespace App\Http\Controllers;

use App\Company;
use App\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('update');

        $companies = Company::all();

        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        $this->authorize('update');

        $company = new Company();

        return view('admin.companies.create', compact( 'company' ));
    }

    public function store()
    {
        $this->authorize('update');

        Company::create($this->validateRequest());

        return redirect('admin/companies');
    }

    public function show(Company $company)
    {
        $this->authorize('update');

        return view('admin.companies.show', compact('company'));
    }

    public function edit(Company $company)
    {

        $this->authorize('update');

        return view('admin.companies.edit', compact( 'company'));
    }

    public function update(Company $company)
    {
        $this->authorize('update');

        $company->update($this->validateRequest());

        return redirect($company->path());
    }

    public function destroy(Company $company)
    {
        $this->authorize('update');

        $company->delete();

        return redirect('admin/companies');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'name'=> 'sometimes|required',

        ]);
    }

}
