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
use function compact;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.user']);
    }

    public function index(Company $company, Employee $employee): Renderable
    {
        $this->authorize('view', $employee);

        $employees = Employee::where('company_id', $company)->get();

        return view('user.employees.index', compact('employees', 'company', 'employee'));
    }

    public function create(Company $company, Employee $employee): Renderable
    {
        $this->authorize('update', $employee);

        $employee = new Employee();

        $positions = $company->positions;

        return view('user.employees.create', compact('positions', 'employee', 'company'));
    }

    public function store(StoreUserEmployeeRequest $request, Company $company, Employee $employee): RedirectResponse
    {
        $this->authorize('update', $employee);

        $employee = new Employee(request(['name', 'surname', 'number', 'company_id']));

        $employee->company_id = $company;

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
        return view('user.employees.show', compact('employee', 'company'));
    }

    public function edit(Company $company, Employee $employee): Renderable
    {
        $this->authorize('update', $employee);

        $positions = Position::all();

        return view('user.employees.edit', compact('employee', 'company', 'positions'));
    }

    public function update(UpdateUserEmployeeRequest $request, Company $company, Employee $employee): RedirectResponse
    {
        $this->authorize('update', $employee);

        $employee->update(request(['name', 'surname', 'number']));

        $employee->company_id = $company;

        $employee->save();

        $employee->positions()->sync(request('position_id'));

        foreach ($employee->positions as $position) {
            $employee->departments()->sync($position->department_id, false);
            foreach ($position->trainings as $training) {
                $employee->trainings()->sync($training, false);
            }
        }

        return redirect($employee->userpath($company));
    }

    public function destroy(Company $company, Employee $employee): RedirectResponse
    {
        $employee->delete();

        return redirect()->route('user.employees.index', [$company]);
    }
}
