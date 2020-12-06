<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View as IlluminateView;

use function redirect;
use function request;
use function view;

class RoleController extends Controller
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

        $roles = Role::all();

        return view('admin.roles.index', ['roles' => $roles]);
    }

//    /**
//     * @return Factory|IlluminateView
//     */
//    public function create()
//    {
//        $this->authorize('update');
//
//        $role = new Role();
//
//        return view('admin.roles.create', ['role' => $role]);
//    }
//
//    /**
//     * @return  RedirectResponse|Redirector
//     */
//    public function store()
//    {
//        $this->authorize('update');
//
//        $role = Role::create($this->validateRequest());
//
//        return redirect($role->path());
//    }
//
//    public function show(): void
//    {
//        $this->authorize('update');
//    }
//
//    public function edit(Role $role): void
//    {
//        $this->authorize('update');
//    }
//
//    /**
//     * @return  RedirectResponse|Redirector
//     */
//    public function update(Role $role)
//    {
//        $this->authorize('update');
//
//        $role->update($this->validateRequest());
//
//        return redirect($role->path());
//    }
//
//    /**
//     * @return  RedirectResponse|Redirector
//     */
//    public function destroy(Role $role)
//    {
//        $this->authorize('update');
//
//        $role->delete();
//
//        return redirect('/admin/roles');
//    }
//
//    protected function validateRequest()
//    {
//        return request()->validate([
//            'name' => 'required|sometimes',
//            'description' => 'required|sometimes',
//        ]);
//    }
}
