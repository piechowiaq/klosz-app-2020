<?php

namespace App\Http\Controllers;



use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::all();

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $role = new Role();

        return view('admin.roles.create', compact( 'role' ));
    }

    public function store()
    {
        $role = Role::create([
            'name' => request('name'),
            'description' => request('description')
        ]);

        return redirect($role->path());

    }

    public function update(Role $role)
    {
        $role->update($this->validateRequest());

        return redirect($role->path());
    }

    public function edit(Role $role)
    {

    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect('/admin/roles');
    }
    protected function validateRequest()
    {
        return request()->validate([
            'name'=> 'sometimes|required',
            'description'=> 'sometimes|required',

        ]);
    }






}
