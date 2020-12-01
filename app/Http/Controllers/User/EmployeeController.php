<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserEmployeeRequest;
use App\Http\Requests\UpdateUserEmployeeRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

use function redirect;
use function request;
use function view;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.user']);
    }

    public function index(Company $company, Employee $employee): Renderable
    {
        $this->authorize('view', $employee);

        $employees = Employee::where('company_id', $company->getId())->get();

        return view('user.employees.index')->with(['employees' => $employees, 'company' => $company, 'employee' => $employee]);
    }

    public function create(Company $company, Employee $employee): Renderable
    {
        $this->authorize('update', $employee);

        $employee = new Employee();

        $positions = $company->positions;

        return view('user.employees.create')->with(['positions' => $positions, 'employee' => $employee, 'company' => $company]);
    }

    public function store(StoreUserEmployeeRequest $request, Company $company, Employee $employee): RedirectResponse
    {
        $this->authorize('update', $employee);

        $employee = new Employee(request(['name', 'surname', 'number', 'company_id']));

        $employee->company_id = $company->getId();

        $employee->save();

        $employee->positions()->sync(request('position_id'));

        foreach ($employee->positions as $position) {
            $employee->departments()->sync($position->department_id, false);
            foreach ($position->trainings as $training) {
                $employee->trainings()->sync($training, false);
            }
        }

        return redirect()->route('user.employees.index', [$company]);
    }

    public function show(Company $company, Employee $employee): Renderable
    {
        return view('user.employees.show')->with(['employee' => $employee, 'company' => $company]);
    }

    public function edit(Company $company, Employee $employee): Renderable
    {
        $this->authorize('update', $employee);

        $positions = $company->getPositions();

        return view('user.employees.edit')->with(['employee' => $employee, 'company' => $company, 'positions' => $positions]);
    }

    public function update(UpdateUserEmployeeRequest $request, Company $company, Employee $employee): RedirectResponse
    {
        $this->authorize('update', $employee);

        $employee->update(request(['name', 'surname', 'number']));

        $employee->save();

        $employee->positions()->sync(request('position_id'));

        foreach ($employee->positions as $position) {
            $employee->departments()->sync($position->department_id, false);
            foreach ($position->trainings as $training) {
                $employee->trainings()->sync($training, false);
            }
        }

        return redirect($employee->userpath($company->getId()));
    }

    public function destroy(Company $company, Employee $employee): RedirectResponse
    {
        $employee->delete();

        return redirect()->route('user.employees.index', [$company->getId()]);
    }
}
