<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        $companies = Company::all();

        $user = new User();

        return view('admin.users.create', compact( 'roles', 'companies','user' ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validateRequest();

        $user = new User(request(['name', 'surname', 'email', 'password']));

        $user->save();

        $user->roles()->attach(request('role_id'));

        $user->companies()->attach(request('company_id'));

        return redirect('admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $companies = Company::all();

        $roles = Role::all();

        return view ( 'admin.users.edit', compact('user', 'companies', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        $this->validateRequest();

        $user->update(request(['name', 'surname', 'email']));

        $user->roles()->sync(request('role_id'));

        $user->companies()->sync(request('company_id'));

        return redirect($user->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect('/admin/users');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'name'=> 'required',
            'surname'=> 'required',
            'email' => 'required|unique:users',
            'password'=> 'required',
            'role_id' => 'exists:companies,id|required',
            'company_id'=> 'exists:companies,id|required',
        ]);
    }
}
