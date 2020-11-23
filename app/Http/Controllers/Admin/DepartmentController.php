<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use function compact;
use function redirect;
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

        return view('admin.departments.index', compact('departments'));
    }

    public function create(): Renderable
    {
        $this->authorize('update');
        $department = new Department();

        return view('admin.departments.create', compact('department'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('update');

        $department = Department::create($this->validateRequest());

        return redirect($department->path());
    }

    public function show(Department $department): Response
    {
        $this->authorize('update');

        return view('admin.departments.show', compact('department'));
    }

    public function edit(Department $department): Response
    {
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department): Response
    {
        $this->authorize('update');

        $department->update($this->validateRequest());

        return redirect($department->path());
    }

    public function destroy(Department $department): Response
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
