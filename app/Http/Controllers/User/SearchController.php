<?php

namespace App\Http\Controllers\User;

use App\Company;
use App\Employee;
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

        if(\request()->expectsJson()){

            return $employees;
        }

        return view('user.employees.index', compact('employees', 'company', 'employee'));

    }
}
