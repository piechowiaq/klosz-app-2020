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
use DateTime;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View as IlluminateView;

use function redirect;
use function request;
use function view;

class UserController extends Controller
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

        $users = User::all();

        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function create()
    {
        $this->authorize('update');

        $roles = Role::all();

        $companies = Company::all();

        $user = new User();

        return view('admin.users.create', ['roles' => $roles, 'companies' => $companies, 'user' => $user]);
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('update');

        $user = new User();
        $user->setName($request->get('name'));
        $user->setSurname($request->get('surname'));
        $user->setEmail($request->get('email'));
        $user->setPassword($request->get('password'));
        $user->setEmailVerifiedAt(new DateTime());
        $user->save();

        $user->setRoles(Role::getRolesById($request->get('role_id')));
        $user->setCompanies(Company::getCompaniesById($request->get('company_id')));

        return redirect($user->path());
    }

    /**
     * @return Factory|IlluminateView
     */
    public function show(User $user)
    {
        $this->authorize('update');

        return view('admin.users.show', ['user' => $user]);
    }

    /**
     * @return Factory|IlluminateView
     */
    public function edit(User $user)
    {
        $this->authorize('update');

        $companies = Company::all();

        $roles = Role::all();

        return view('admin.users.edit', ['user' => $user, 'companies' => $companies, 'roles' => $roles]);
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update');

        $user->setName($request->get('name'));
        $user->setSurname($request->get('surname'));
        $user->setEmail($request->get('email'));
        $user->setPassword($request->get('password'));
        $user->setEmailVerifiedAt(new DateTime());
        $user->save();

        $user->setRoles(Role::getRolesById($request->get('role_id')));
        $user->setCompanies(Company::getCompaniesById($request->get('company_id')));

        return redirect($user->path());
    }

    /**
     * @return  RedirectResponse|Redirector
     */
    public function destroy(User $user)
    {
        $this->authorize('update');

        $user->delete();

        return redirect('/admin/users');
    }
}
