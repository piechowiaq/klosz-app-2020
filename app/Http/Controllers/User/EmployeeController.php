<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserEmployeeRequest;
use App\Http\Requests\UpdateUserEmployeeRequest;
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
        $this->middleware(['auth', 'auth.user']);
    }

    public function index($companyId, Employee $employee): Renderable
    {
        $this->authorize('view', $employee);

        $company = Company::findOrFail($companyId);

        $employees = Employee::where('company_id', $companyId)->get();

        return view('user.employees.index')->with(['employees' => $employees, 'company' => $company, 'employee' => $employee]);
    }

    public function create($companyId, Employee $employee): Renderable
    {
        $this->authorize('update', $employee);

        $employee = new Employee();

        $company = Company::findOrFail($companyId);

        $positions = $company->positions;

        return view('user.employees.create')->with(['positions' => $positions, 'employee' => $employee, 'company' => $company]);
    }

    public function store(StoreUserEmployeeRequest $request, $companyId, Employee $employee): RedirectResponse
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

    public function show($companyId, Employee $employee): Renderable
    {
        $company = Company::findOrFail($companyId);

        return view('user.employees.show')->with(['employee' => $employee, 'company' => $company]);
    }

    public function edit($companyId, Employee $employee): Renderable
    {
        $this->authorize('update', $employee);

        $positions = Position::all();

        $company = Company::findOrFail($companyId);

        return view('user.employees.edit')->with(['employee' => $employee, 'company' => $company, 'positions' => $positions]);
    }

    public function update(UpdateUserEmployeeRequest $request, $companyId, Employee $employee): RedirectResponse
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

    public function destroy($companyId, Employee $employee): RedirectResponse
    {
        $employee->delete();

        return redirect()->route('user.employees.index', [$companyId]);
    }
}
