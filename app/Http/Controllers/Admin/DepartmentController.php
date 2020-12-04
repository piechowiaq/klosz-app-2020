<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use function redirect;
use function request;
use function view;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Renderable
    {
        $this->authorize('update');

        $departments = Department::all();

        return view('admin.departments.index')->with(['departments' => $departments]);
    }

    public function create(): Renderable
    {
        $this->authorize('update');

        $department = new Department();

        return view('admin.departments.create')->with(['department' => $department]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('update');

        $department = Department::create($this->validateRequest());

        return redirect($department->path());
    }

    public function show(Department $department): Renderable
    {
        $this->authorize('update');

        return view('admin.departments.show')->with(['department' => $department]);
    }

    public function edit(Department $department): Renderable
    {
        return view('admin.departments.edit')->with(['department' => $department]);
    }

    public function update(Request $request, Department $department): RedirectResponse
    {
        $this->authorize('update');

        $department->update($this->validateRequest());

        return redirect($department->path());
    }

    public function destroy(Department $department): RedirectResponse
    {
        $this->authorize('update');

        $department->delete();

        return redirect('admin/departments');
    }

    protected function validateRequest()
    {
        return request()->validate(['name' => 'sometimes|required']);
    }
}
