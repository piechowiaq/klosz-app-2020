<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View as IlluminateView;

use function redirect;
use function route;
use function view;

class DepartmentController extends Controller
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

        $departments = Department::getAll();

        return view('admin.departments.index', ['departments' => $departments]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function create()
    {
        $this->authorize('update');

        return view('admin.departments.create');
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function store(StoreDepartmentRequest $request)
    {
        $this->authorize('update');

        $department = new Department();
        $department->setName($request->get('name'));
        $department->save();

        return redirect(route('admin.departments.show', ['department' => $department]));
    }

    /**
     * @return Factory|IlluminateView
     */
    public function show(Department $department)
    {
        $this->authorize('update');

        return view('admin.departments.show', ['department' => $department]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function edit(Department $department)
    {
        $this->authorize('update');

        return view('admin.departments.edit', ['department' => $department]);
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $this->authorize('update');

        $department->setName($request->get('name'));
        $department->save();

        return redirect(route('admin.departments.show', ['department' => $department]));
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function destroy(Department $department)
    {
        $this->authorize('update');

        $department->delete();

        return redirect(route('admin.departments.index'));
    }
}
