<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Controllers\Controller;
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

         $user = User::create($this->validateRequest());

         request()->validate([
                'role_id'=>'required',
                'company_id' =>'required']);

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
        $user->companies()->detach();
        $user->roles()->detach();

        request()->validate(['role_id'=>'required', 'company_id' =>'required']);

        //Rule::unique to allow unique name of the training when editing

        $user->update(request()->validate([
            'name'=> 'sometimes|required',
            'surname'=> 'sometimes|required',
            'email' => [
                'required', 'sometimes',
                Rule::unique('users')->ignore($user->id),
            ],
            'password'=> 'sometimes|required',
        ]));

        $user->roles()->attach(request('role_id'));
        $user->companies()->attach(request('company_id'));

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
            'name'=> 'sometimes|required',
            'surname'=> 'sometimes|required',
            'email' => 'sometimes|required|unique:users',
            'password'=> 'sometimes|required',
//            'role_id' => 'sometimes|required',
//            'company_id'=> 'sometimes|required',
        ]);
    }
}
