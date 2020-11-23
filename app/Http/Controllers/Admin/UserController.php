<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('update');

        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('update');

        $roles = Role::all();

        $companies = Company::all();

        $user = new User();

        return view('admin.users.create', compact( 'roles', 'companies','user' ));
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('update');

        $user = new User(request(['name', 'surname', 'email']));

        $user->password = Hash::make($request['password']);

        $user->email_verified_at = Carbon::now();

        $user->save();

        $user->roles()->attach(request('role_id'));

        $user->companies()->attach(request('company_id'));

        return redirect($user->path());
    }

    public function show(User $user)
    {
        $this->authorize('update');


        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update');

        $companies = Company::all();

        $roles = Role::all();

        return view ( 'admin.users.edit', compact('user', 'companies', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update');

        $user->update(request(['name', 'surname', 'email']));

        $user->password = Hash::make($request['password']);

        $user->email_verified_at = Carbon::now();

        $user->save();

        $user->roles()->sync(request('role_id'));

        $user->companies()->sync(request('company_id'));

        return redirect($user->path());
    }

    public function destroy(User $user)
    {
        $this->authorize('update');

        $user->delete();

        return redirect('/admin/users');
    }

}
