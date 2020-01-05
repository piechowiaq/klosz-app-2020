<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        return view('admin.companies.index');
    }

    public function store()
    {
        Company::create($this->validateRequest());
    }

    public function edit(Company $company)
    {
        //
    }

    public function update(Company $company)
    {
        $company->update($this->validateRequest());

        return redirect($company->path());
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect('/admin/companies');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'name'=> 'sometimes|required',

        ]);
    }

}
