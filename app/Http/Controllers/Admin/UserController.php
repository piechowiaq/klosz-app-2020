<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

use function compact;
use function redirect;
use function request;
use function view;

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

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $this->authorize('update');

        $roles = Role::all();

        $companies = Company::all();

        $user = new User();

        return view('admin.users.create', compact('roles', 'companies', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(StoreUserRequest $request): Response
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

    /**
     * Display the specified resource.
     */
    public function show(User $user): Response
    {
        $this->authorize('update');

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Response
    {
        $this->authorize('update');

        $companies = Company::all();

        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'companies', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     */
    public function update(UpdateUserRequest $request, User $user): Response
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): Response
    {
        $this->authorize('update');

        $user->delete();

        return redirect('/admin/users');
    }
}
