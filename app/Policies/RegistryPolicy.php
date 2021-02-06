<?php

declare(strict_types=1);

namespace App\Policies;

use App\Company;
use App\Registry;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegistryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->isManager() || $user->isUser();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return mixed
     */
    public function view(User $user, Registry $registry, Company $company)
    {
        return $user->getRegistriesByCompany($company)->contains($registry) && ($user->isAdmin() || $user->isManager() || $user->isUser());
    }

    /**
     * Determine whether the user can create models.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return mixed
     */
    public function update(User $user, Registry $registry)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return mixed
     */
    public function delete(User $user, Registry $registry)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return mixed
     */
    public function restore(User $user, Registry $registry)
    {
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return mixed
     */
    public function forceDelete(User $user, Registry $registry)
    {
    }
}
