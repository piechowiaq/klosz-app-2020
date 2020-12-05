<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserEmployeeRequest;
use App\Http\Requests\UpdateUserEmployeeRequest;
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
        $this->middleware(['auth', 'auth.user']);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function index(Company $company, Employee $employee)
    {
        $this->authorize('view', $employee);

        return view('user.employees.index', ['employees' => $company->getEmployees(), 'company' => $company, 'employee' => $employee]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function create(Company $company, Employee $employee)
    {
        $this->authorize('update', $employee);

        $employee = new Employee();

        return view('user.employees.create', ['positions' => $company->getPositions(), 'employee' => $employee, 'company' => $company]);
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function store(StoreUserEmployeeRequest $request, Company $company, Employee $employee)
    {
        $this->authorize('update', $employee);

        $employee = new Employee(request(['name', 'surname', 'number', 'company_id']));

        $employee->setCompany($company);

        $employee->save();

        $employee->setPositions(request('position_id'));

        foreach ($employee->positions as $position) {
            $employee->departments()->sync($position->department_id, false);
            foreach ($position->trainings as $training) {
                $employee->trainings()->sync($training, false);
            }
        }

        return redirect()->route('user.employees.index', [$company]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function show(Company $company, Employee $employee)
    {
        $this->authorize('update', $employee);

        return view('user.employees.show', ['employee' => $employee, 'company' => $company]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function edit(Company $company, Employee $employee)
    {
        $this->authorize('update', $employee);

        $positions = $company->getPositions();

        return view('user.employees.edit', ['employee' => $employee, 'company' => $company, 'positions' => $positions]);
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function update(UpdateUserEmployeeRequest $request, Company $company, Employee $employee)
    {
        $this->authorize('update', $employee);

        $employee->update(request(['name', 'surname', 'number']));

        $employee->save();

        $employee->setCompany($company);

        $employee->setPositions(request('position_id'));

        foreach ($employee->positions as $position) {
            $employee->departments()->sync($position->department_id, false);
            foreach ($position->trainings as $training) {
                $employee->trainings()->sync($training, false);
            }
        }

        return redirect($employee->userPath($company));
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function destroy(Company $company, Employee $employee)
    {
        $employee->delete();

        return redirect()->route('user.employees.index', [$company->getId()]);
    }
}
