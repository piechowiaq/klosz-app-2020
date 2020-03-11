<?php

namespace App\Http\Controllers\User;

use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
//        $this->authorize('update');



        $company = Company::findOrFail($id);

        $employees = Employee::where('company_id', $id)->get();

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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('update');

        $positions = Position::all();

        $companies = Company::all();

        $employee = new Employee();

        return view('user.employees.create', compact( 'positions', 'companies','employee' ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        $this->authorize('update');

        $employee = new Employee(request(['name', 'surname', 'number', 'company_id']));

        $employee->save();


        $employee->positions()->sync(request('position_id'));

        foreach ($employee->positions as $position) {
            foreach ($position->trainings as $training){

                $employee->trainings()->sync($training, false);

            }}

        return redirect($employee->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {

        //$this->authorize('update');

        return view('user.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {

//        $this->authorize('update');

        $positions = Position::all();

        $companies = Company::all();

        return view ( 'user.employees.edit', compact('employee', 'companies', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $this->authorize('update');

        $employee->update(request(['name', 'surname', 'number', 'company_id']));

        $employee->save();

        $employee->positions()->sync(request('position_id'));

        foreach ($employee->positions as $position) {
            foreach ($position->trainings as $training){

                $employee->trainings()->sync($training, false);

            }}

        return redirect($employee->path());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */


}
