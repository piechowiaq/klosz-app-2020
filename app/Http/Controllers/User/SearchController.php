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
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View as IlluminateView;

use function request;
use function view;

class SearchController extends Controller
{
    /**
     * @return mixed|Factory|IlluminateView
     */
    public function show(Company $company, Employee $employee)
    {
        $this->authorize('view', $employee);

        $search = request('q');

        $employees = Employee::search($search)->where('company_id', $company->getId())->paginate(25);

        if (request()->expectsJson()) {
            return $employees;
        }

        return view('user.employees.index', ['employees' => $employees, 'company' => $company, 'employee' => $employee]);
    }

    /**
     * @return mixed|Factory|IlluminateView
     */
    public function registries(Company $company, Report $report)
    {
        $this->authorize('view', $report);

        $search = request('q');

        $companyRegistries = Registry::search($search)->whereHas('companies', static function ($query) use ($company): void {
            $query->where('company_id', '=', $company);
        })->paginate(25);

        if (request()->expectsJson()) {
            return $companyRegistries;
        }

        return view('user.registries.index', ['companyRegistries' => $companyRegistries, 'company' => $company, 'report' => $report]);
    }

    /**
     * @return mixed|Factory|IlluminateView
     */
    public function trainings(Company $company, Certificate $certificate)
    {
        $search = request('q');

        $companyTrainings = Training::search($search)->whereHas('companies', static function ($query) use ($company): void {
            $query->where('company_id', '=', $company);
        })->paginate(25);

        if (request()->expectsJson()) {
            return $companyTrainings;
        }

        return view('user.trainings.index', ['companyTrainings' => $companyTrainings, 'company' => $company, 'certificate' => $certificate, 'companyId' => $company->getId()]);
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
