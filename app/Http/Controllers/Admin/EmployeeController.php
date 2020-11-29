<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Position;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use function compact;
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
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $this->authorize('update');

        $employees = Employee::all();

        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize('update');

        $positions = Position::all();

        $companies = Company::all();

        $employee = new Employee();

        return view('admin.employees.create', compact('positions', 'companies', 'employee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(StoreEmployeeRequest $request): Response
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
     * Display the specified resource.
     */
    public function show(Employee $employee): Response
    {
        $this->authorize('update');

        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee): Response
    {
        $this->authorize('update');

        $positions = Position::all();

        $companies = Company::all();

        return view('admin.employees.edit', compact('employee', 'companies', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee): Response
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
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee): Response
    {
        $this->authorize('update');

        $employee->delete();

        return redirect('admin/employees');
    }
}
