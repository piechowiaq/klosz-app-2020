<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

use function redirect;
use function request;
use function view;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Renderable
    {
        $this->authorize('update');

        $roles = Role::all();

        return view('admin.roles.index')->with(['roles' => $roles]);
    }

    public function create(): Renderable
    {
        $this->authorize('update');

        $role = new Role();

        return view('admin.roles.create')->with(['role' => $role]);
    }

    public function store(): RedirectResponse
    {
        $this->authorize('update');

        $role = Role::create($this->validateRequest());

        return redirect($role->path());
    }

    public function show(): void
    {
        $this->authorize('update');
    }

    public function edit(Role $role): void
    {
        $this->authorize('update');
    }

    public function update(Role $role): RedirectResponse
    {
        $this->authorize('update');

        $role->update($this->validateRequest());

        return redirect($role->path());
    }

    public function destroy(Role $role): RedirectResponse
    {
        $this->authorize('update');

        $role->delete();

        return redirect('/admin/roles');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'name' => 'required|sometimes',
            'description' => 'required|sometimes',
        ]);
    }
}
