<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use function compact;
use function redirect;
use function request;
use function view;

class DepartmentController extends Controller
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

        $departments = Department::all();

        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $this->authorize('update');
        $department = new Department();

        return view('admin.departments.create', compact('department'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        $this->authorize('update');

        $department = Department::create($this->validateRequest());

        return redirect($department->path());
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department): Response
    {
        $this->authorize('update');

        return view('admin.departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department): Response
    {
        return view('admin.departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department): Response
    {
        $this->authorize('update');

        $department->update($this->validateRequest());

        return redirect($department->path());
    }

    /**
     * Remove the specified resource from storage.
     */
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
