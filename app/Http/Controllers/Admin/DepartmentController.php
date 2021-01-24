<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as IlluminateView;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

use function redirect;
use function route;
use function view;

class DepartmentController extends Controller
{
    /**
     * @return Factory|IlluminateView
{     */
    public function index()
    {
        $departments = Department::getAll();

        return view('admin.departments.index', ['departments' => $departments]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function create()
    {
        return view('admin.departments.create');
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function store(StoreDepartmentRequest $request)
    {
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
        return view('admin.departments.show', ['department' => $department]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function edit(Department $department)
    {
        return view('admin.departments.edit', ['department' => $department]);
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department->setName($request->get('name'));
        $department->save();

        return redirect(route('admin.departments.show', ['department' => $department]));
    }

    /**
     * @return  RedirectResponse|Redirector
     *
     * @throws Exception
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return redirect(route('admin.departments.index'));
    }
}
