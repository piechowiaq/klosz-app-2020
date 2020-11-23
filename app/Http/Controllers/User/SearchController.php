<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Certificate;
use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Registry;
use App\Report;
use App\Training;

use Illuminate\Contracts\Support\Renderable;
use function compact;
use function request;

class SearchController extends Controller
{
    public function show($companyId, Employee $employee): Renderable
    {
        $this->authorize('view', $employee);

        $company = Company::findOrFail($companyId);

        $search = request('q');

        $employees = Employee::search($search)->where('company_id', $companyId)->paginate(25);

        if (request()->expectsJson()) {
            return $employees;
        }

        return view('user.employees.index', compact('employees', 'company', 'employee'));
    }

    public function registries($companyId, Report $report): Renderable
    {
        $this->authorize('view', $report);

        $company = Company::findOrFail($companyId);

        $search = request('q');

        $companyRegistries = Registry::search($search)->whereHas('companies', static function ($query) use ($companyId): void {
            $query->where('company_id', '=', $companyId);
        })->paginate(25);

        if (request()->expectsJson()) {
            return $companyRegistries;
        }

        return view('user.registries.index', compact('companyRegistries', 'company', 'report'));
    }

    public function trainings($companyId, Certificate $certificate): Renderable
    {
        $company = Company::findOrfail($companyId);

        $search = request('q');

        $companyTrainings = Training::search($search)->whereHas('companies', static function ($query) use ($companyId): void {
            $query->where('company_id', '=', $companyId);
        })->paginate(25);

        if (request()->expectsJson()) {
            return $companyTrainings;
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
