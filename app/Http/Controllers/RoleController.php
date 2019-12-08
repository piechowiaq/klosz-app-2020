<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function store()
    {
        Role::create($this->validateRequest());
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
