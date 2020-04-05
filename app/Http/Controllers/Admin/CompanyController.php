<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Position;
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

        $departments = Department::all();

        return view('admin.companies.create', compact( 'company' , 'departments'));
    }

    public function store(StoreCompanyRequest $request)
    {
        $this->authorize('update');

        $company = new Company(request(['name']));

        $company->save();

        $company->departments()->sync(request('department_id'));

        $departmentsId =  $company->departments->map(function($department){
            return $department->id;
        });

        Position::whereIn('department_id', $departmentsId)
                            ->get()
                            ->map(function($position) use ($company)
        {
            $position->companies()->sync($company, false);
        });

        return redirect($company->path());
    }

    public function show(Company $company)
    {
        $this->authorize('update');

        return view('admin.companies.show', compact('company'));
    }

    public function edit(Company $company)
    {

        $this->authorize('update');

        $departments = Department::all();

        return view('admin.companies.edit', compact( 'company', 'departments'));
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $this->authorize('update');

        $company->update(request(['name']));


        $company->departments()->sync(request('department_id'));

        $departmentsId =  $company->departments->map(function($department){
            return $department->id;
        });

        Position::whereIn('department_id', $departmentsId)
            ->get()
            ->map(function($position) use ($company)
            {
                $position->companies()->sync($company, false);
            });

        return redirect($company->path());
    }

    public function destroy(Company $company)
    {
        $this->authorize('update');

        $company->delete();

        return redirect('admin/companies');
    }

}
