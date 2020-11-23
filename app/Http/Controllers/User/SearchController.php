<?php

namespace App\Http\Controllers\User;

use App\Certificate;
use App\Company;
use App\Employee;
use App\Position;
use App\Registry;
use App\Report;
use App\Training;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function show($companyId, Employee $employee)
    {
        $this->authorize('view', $employee);

        $company = Company::findOrFail($companyId);

        $search = \request('q');

        $employees = Employee::search($search)->where('company_id', $companyId)->paginate(25);

        if (\request()->expectsJson()) {
            return $employees;
        }

        return view('user.employees.index', compact('employees', 'company', 'employee'));
    }

    public function registries($companyId, Report $report)
    {
        $this->authorize('view', $report);

        $company = Company::findOrFail($companyId);

        $search = \request('q');

        $companyRegistries = Registry::search($search)->whereHas('companies', function ($query) use ($companyId) {
            $query->where('company_id', '=', $companyId);
        })->paginate(25);


        if (\request()->expectsJson()) {
            return  $companyRegistries;
        }

        return view('user.registries.index', compact('companyRegistries', 'company', 'report'));
    }

    public function trainings($companyId, Certificate $certificate)
    {

        $company = Company::findOrfail($companyId);

        $search = \request('q');

        $companyTrainings = Training::search($search)->whereHas('companies', function ($query) use ($companyId) {
            $query->where('company_id', '=', $companyId);
        })->paginate(25);

        if (\request()->expectsJson()) {
            return   $companyTrainings;
        }

        return view('user.trainings.index', compact('companyTrainings', 'company', 'certificate', 'companyId'));
    }






















//        $companyRegistries = Registry::search($search)->whereHas('companies', function($query) use ($companyId){
//            $query->where('company_id', '=', $companyId);
//        })->paginate(25);
//
//
//        if(\request()->expectsJson()){
//
//            return  $companyTrainings;
//        }
//
//        return view('user.registries.index', compact('companyRegistries', 'company', 'report'));
//
//    }
}
