<?php

namespace App\Http\Controllers\User;

use App\Certificate;
use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserEmployeeRequest;
use App\Http\Requests\UpdateUserEmployeeRequest;
use App\Position;
use App\Training;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.user']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $companyId
     * @return \Illuminate\Http\Response
     */
    public function index($companyId, Employee $employee)
    {


        $company = Company::findOrFail($companyId);

        $employees = Employee::where('company_id', $companyId)->get();

        return view('user.employees.index', compact('employees', 'company', 'employee'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function create($companyId, Employee $employee)
    {
        $this->authorize('update', $employee);

        $employee = new Employee();

        $company = Company::findOrFail($companyId);

        $positions = $company->positions;

        return view('user.employees.create', compact( 'positions', 'employee', 'company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserEmployeeRequest $request
     * @param $companyId
     * @param Employee $employee
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreUserEmployeeRequest $request, $companyId, Employee $employee)
    {
        $this->authorize('update', $employee);

        $employee = new Employee(request(['name', 'surname', 'number']));

        $employee->company_id = $companyId;

        $employee->save();

        $employee->positions()->sync(request('position_id'));


        foreach ($employee->positions as $position) {
            $employee->departments()->sync($position->department_id,false);
            foreach ($position->trainings as $training){
                $employee->trainings()->sync($training, false);
            }}

        return redirect($employee->userpath($companyId));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Employee $employee
     * @param $company
     * @return \Illuminate\Http\Response
     */
    public function show($companyId, Employee $employee)
    {

        $company = Company::findOrFail($companyId);


        return view('user.employees.show', compact('employee', 'company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($companyId, Employee $employee)
    {

        $this->authorize('update', $employee);

        $positions = Position::all();

        $company = Company::findOrFail($companyId);

        return view ( 'user.employees.edit', compact('employee', 'company', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserEmployeeRequest $request, $companyId, Employee $employee)
    {
        $this->authorize('update', $employee);

        $employee->update(request(['name', 'surname', 'number']));

        $employee->company_id = $companyId;

        $employee->save();

        $employee->positions()->sync(request('position_id'));

        foreach ($employee->positions as $position) {
            $employee->departments()->sync($position->department_id,false);
            foreach ($position->trainings as $training){
                $employee->trainings()->sync($training, false);
            }}

        return redirect($employee->userpath($companyId));

    }



}
