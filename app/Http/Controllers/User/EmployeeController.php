<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserEmployeeRequest;
use App\Http\Requests\UpdateUserEmployeeRequest;
use App\Position;

use function compact;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.user']);
    }

    public function index($companyId, Employee $employee)
    {
        $this->authorize('view', $employee);

        $company = Company::findOrFail($companyId);

        $employees = Employee::where('company_id', $companyId)->get();

        return view('user.employees.index', compact('employees', 'company', 'employee'));
    }

    public function create($companyId, Employee $employee)
    {
        $this->authorize('update', $employee);

        $employee = new Employee();

        $company = Company::findOrFail($companyId);

        $positions = $company->positions;

        return view('user.employees.create', compact('positions', 'employee', 'company'));
    }

    public function store(StoreUserEmployeeRequest $request, $companyId, Employee $employee)
    {
        $this->authorize('update', $employee);

        $employee = new Employee(request(['name', 'surname', 'number', 'company_id']));

        $employee->company_id = $companyId;

        $employee->save();

        $employee->positions()->sync(request('position_id'));

        foreach ($employee->positions as $position) {
            $employee->departments()->sync($position->department_id, false);
            foreach ($position->trainings as $training) {
                $employee->trainings()->sync($training, false);
            }
        }

        return redirect()->route('user.employees.index', [$companyId]);
    }

    public function show($companyId, Employee $employee)
    {
        $company = Company::findOrFail($companyId);

        return view('user.employees.show', compact('employee', 'company'));
    }

    public function edit($companyId, Employee $employee)
    {
        $this->authorize('update', $employee);

        $positions = Position::all();

        $company = Company::findOrFail($companyId);

        return view('user.employees.edit', compact('employee', 'company', 'positions'));
    }

    public function update(UpdateUserEmployeeRequest $request, $companyId, Employee $employee)
    {
        $this->authorize('update', $employee);

        $employee->update(request(['name', 'surname', 'number']));

        $employee->company_id = $companyId;

        $employee->save();

        $employee->positions()->sync(request('position_id'));

        foreach ($employee->positions as $position) {
            $employee->departments()->sync($position->department_id, false);
            foreach ($position->trainings as $training) {
                $employee->trainings()->sync($training, false);
            }
        }

        return redirect($employee->userpath($companyId));
    }

    public function destroy($companyId, Employee $employee)
    {
        $employee->delete();

        return redirect()->route('user.employees.index', [$companyId]);
    }
}
