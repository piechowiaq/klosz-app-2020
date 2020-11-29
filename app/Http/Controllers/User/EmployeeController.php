<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserEmployeeRequest;
use App\Http\Requests\UpdateUserEmployeeRequest;
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
        $this->middleware(['auth', 'auth.user']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $companyId
     */
    public function index($companyId, Employee $employee): Response
    {
        $this->authorize('view', $employee);

        $company = Company::findOrFail($companyId);

        $employees = Employee::where('company_id', $companyId)->get();

        return view('user.employees.index', compact('employees', 'company', 'employee'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     */
    public function create($companyId, Employee $employee): Response
    {
        $this->authorize('update', $employee);

        $employee = new Employee();

        $company = Company::findOrFail($companyId);

        $positions = $company->positions;

        return view('user.employees.create', compact('positions', 'employee', 'company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $companyId
     *
     * @throws AuthorizationException
     */
    public function store(StoreUserEmployeeRequest $request, $companyId, Employee $employee): Response
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

    /**
     * Display the specified resource.
     *
     * @param $company
     */
    public function show($companyId, Employee $employee): Response
    {
        $company = Company::findOrFail($companyId);

        return view('user.employees.show', compact('employee', 'company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($companyId, Employee $employee): Response
    {
        $this->authorize('update', $employee);

        $positions = Position::all();

        $company = Company::findOrFail($companyId);

        return view('user.employees.edit', compact('employee', 'company', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     */
    public function update(UpdateUserEmployeeRequest $request, $companyId, Employee $employee): Response
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
