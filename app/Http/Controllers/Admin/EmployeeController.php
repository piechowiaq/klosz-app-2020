<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Position;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View as IlluminateView;

use function redirect;
use function request;
use function view;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return Factory|IlluminateView
     */
    public function index()
    {
        $this->authorize('update');

        $employees = Employee::all();

        return view('admin.employees.index', ['employees' => $employees]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function create()
    {
        $this->authorize('update');

        $positions = Position::all();

        $companies = Company::all();

        $employee = new Employee();

        return view('admin.employees.create', ['positions' => $positions, 'companies' => $companies, 'employee' => $employee]);
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function store(StoreEmployeeRequest $request)
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

    /**
     * @return Factory|IlluminateView
     */
    public function show(Employee $employee)
    {
        $this->authorize('update');

        return view('admin.employees.show', ['employee' => $employee]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function edit(Employee $employee)
    {
        $this->authorize('update');

        $positions = Position::all();

        $companies = Company::all();

        return view('admin.employees.edit', ['employee' => $employee, 'companies' => $companies, 'positions' => $positions]);
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
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

    /**
     * @return  RedirectResponse|Redirector
     */
    public function destroy(Employee $employee)
    {
        $this->authorize('update');

        $employee->delete();

        return redirect('admin/employees');
    }
}
