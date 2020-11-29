<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Position;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

use function redirect;
use function request;
use function view;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Renderable
    {
        $this->authorize('update');

        $employees = Employee::all();

        return view('admin.employees.index')->with(['employees' => $employees]);
    }

    public function create(): Renderable
    {
        $this->authorize('update');

        $positions = Position::all();

        $companies = Company::all();

        $employee = new Employee();

        return view('admin.employees.create')->with(['positions' => $positions, 'companies' => $companies, 'employee' => $employee]);
    }

    public function store(StoreEmployeeRequest $request): RedirectResponse
    {
        $this->authorize('update');

        $employee = new Employee(request(['name', 'surname', 'number', 'company_id']));

        $employee->save();

        $employee->positions()->sync(request('position_id'));

        foreach ($employee->positions as $position) {
            $employee->departments()->sync($position->department_id, false);
            foreach ($position->trainings as $training) {
                $employee->trainings()->sync($training, false);
            }
        }

        return redirect($employee->path());
    }

    public function show(Employee $employee): Renderable
    {
        $this->authorize('update');

        return view('admin.employees.show')->with(['employee' => $employee]);
    }

    public function edit(Employee $employee): Renderable
    {
        $this->authorize('update');

        $positions = Position::all();

        $companies = Company::all();

        return view('admin.employees.edit')->with(['employee' => $employee, 'companies' => $companies, 'positions' => $positions]);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee): RedirectResponse
    {
        $this->authorize('update');

        $employee->update(request(['name', 'surname', 'number', 'company_id']));

        $employee->save();

        $employee->positions()->sync(request('position_id'));

        foreach ($employee->positions as $position) {
            $employee->departments()->sync($position->department_id, false);
            foreach ($position->trainings as $training) {
                $employee->trainings()->sync($training, false);
            }
        }

        return redirect($employee->path());
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        $this->authorize('update');

        $employee->delete();

        return redirect('admin/employees');
    }
}
