<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserEmployeeRequest;
use App\Http\Requests\UpdateUserEmployeeRequest;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View as IlluminateView;

use function redirect;
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
     *
     * @throws Exception
     */
    public function store(StoreUserEmployeeRequest $request, Company $company, Employee $employee)
    {
        $this->authorize('update', $employee);

        $employee = new Employee();
        $employee->setName($request->get('name'));
        $employee->setSurname($request->get('surname'));
        $employee->setNumber((int) $request->get('number'));
        $employee->setCompany($company);
        $employee->save();

        $employee->setPositions($request->get('position_id'));

        $departments = new Collection();
        $trainings   = new Collection();

        foreach ($employee->getPositions() as $position) {
            $departments->add($position->getDepartment());
            $trainings =  $trainings->merge($position->getTrainings());
        }

        $employee->setDepartments($departments);
        $employee->setTrainings($trainings);

        return redirect($company->getId() . '/employees/' . $employee->getID());
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

        $employee->setName($request->get('name'));
        $employee->setSurname($request->get('surname'));
        $employee->setNumber($request->get('number'));
        $employee->setCompany($company);
        $employee->save();

        $employee->setPositions($request->get('position_id'));

        $departments = new Collection();
        $trainings   = new Collection();

        foreach ($employee->getPositions() as $position) {
            $departments->add($position->getDepartment());
            $trainings->add($position->getTrainings());
        }

        $employee->setDepartments($departments);
        $employee->setTrainings($trainings);

        return redirect($employee->userPath($company));
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function destroy(Company $company, Employee $employee)
    {
        $employee->delete();

        return redirect($company->getId() . '/employees');
    }
}
