<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Core\Company\Domain\Repository\CompanyRepositoryInterface;
use App\Core\Role\Domain\Repository\RoleRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use DateTime;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View as IlluminateView;

use function is_array;
use function redirect;
use function view;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return Factory|IlluminateView
     *
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('update');

        $users = User::getAll();

        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * @return Factory|IlluminateView
     *
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('update');

        $roles = Role::getAll();

        $companies = Company::getAll();

        return view('admin.users.create', ['roles' => $roles, 'companies' => $companies]);
    }

    /**
     * @return  RedirectResponse|Redirector
     *
     * @throws AuthorizationException
     */
    public function store(RoleRepositoryInterface $roleRepository, CompanyRepositoryInterface $companyRepository, StoreUserRequest $request)
    {
        $this->authorize('update');

        $user = new User();
        $user->setName($request->get('name'));
        $user->setSurname($request->get('surname'));
        $user->setEmail($request->get('email'));
        $user->setPassword($request->get('password'));
        $user->setEmailVerifiedAt(new DateTime());
        $user->save();

        $rolesIds = $request->get('role_ids');
        $roles    = new Collection();
        if (is_array($rolesIds)) {
            $roles = $roleRepository->getManyByIds($rolesIds);
        }

        $user->setRoles($roles);

        $companyIds = $request->get('company_ids');
        $companies  = new Collection();
        if (is_array($companyIds)) {
            $companies = $companyRepository->getManyByIds($companyIds);
        }

        $user->setCompanies($companies);

        return redirect($user->path());
    }

    /**
     * @return Factory|IlluminateView
     *
     * @throws AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('update');

        return view('admin.users.show', ['user' => $user]);
    }

    /**
     * @return Factory|IlluminateView
     *
     * @throws AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update');

        $companies = Company::getAll();

        $roles = Role::getAll();

        return view('admin.users.edit', ['user' => $user, 'companies' => $companies, 'roles' => $roles]);
    }

    /**
     * @return  RedirectResponse|Redirector
     *
     * @throws AuthorizationException
     */
    public function update(RoleRepositoryInterface $roleRepository, CompanyRepositoryInterface $companyRepository, UpdateUserRequest $request, User $user)
    {
        $this->authorize('update');

        $user->setName($request->get('name'));
        $user->setSurname($request->get('surname'));
        $user->setEmail($request->get('email'));
        $user->setPassword($request->get('password'));
        $user->setEmailVerifiedAt(new DateTime());
        $user->save();

        $rolesIds = $request->get('role_ids');

        $roles = new Collection();
        if (is_array($rolesIds)) {
            $roles = $roleRepository->getManyByIds($rolesIds);
        }

        $user->setRoles($roles);

        $companyIds = $request->get('company_ids');
        $companies  = new Collection();
        if (is_array($companyIds)) {
            $companies = $companyRepository->getManyByIds($companyIds);
        }

        $user->setCompanies($companies);

        return redirect($user->path());
    }

    /**
     * @return  RedirectResponse|Redirector
     *
     * @throws AuthorizationException
     * @throws Exception
     */
    public function destroy(User $user)
    {
        $this->authorize('update');

        $user->delete();

        return redirect('/admin/users');
    }
}
