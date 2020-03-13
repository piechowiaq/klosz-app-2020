<?php

namespace App\Http\Controllers\User;

use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Position;
use App\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function index($companyId)
    {
//        $this->authorize('update');



        $company = Company::findOrFail($companyId);

        $employees = Employee::where('company_id', $companyId)->get();

        return view('user.employees.index', compact('employees', 'company'));




//        $company = auth()->user()->companies()->first();
//
//
//        $employees = Employee::where('company_id', $company->id )->get();
//
//        return view('user.employees.index', compact('employees'));
      }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function create($companyId)
    {
        //$this->authorize('update');

        $positions = Position::all();

        $company = Company::findOrFail($companyId);

        $employee = new Employee();

        return view('user.employees.create', compact( 'positions', 'company','employee' ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreEmployeeRequest $request
     * @param $company
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request, $companyId)
    {
        //$this->authorize('update');



        $employee = new Employee(request(['name', 'surname', 'number']));

        $employee->company_id = $companyId;

        $employee->save();


        $employee->positions()->sync(request('position_id'));

        foreach ($employee->positions as $position) {
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

        //$this->authorize('update');

        $company = Company::findOrFail($companyId);

        $trainings = Training::all();

        return view('user.employees.show', compact('employee', 'company', 'trainings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($companyId, Employee $employee)
    {

//        $this->authorize('update');

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
    public function update(UpdateEmployeeRequest $request, $companyId, Employee $employee)
    {
        //$this->authorize('update');

        $employee->update(request(['name', 'surname', 'number', 'company_id']));

        $employee->save();

        $employee->positions()->sync(request('position_id'));

        foreach ($employee->positions as $position) {
            foreach ($position->trainings as $training){

                $employee->trainings()->sync($training, false);

            }}

        return redirect($employee->userpath($companyId));

    }






    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */


}
