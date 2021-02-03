<?php

namespace App\Policies;

use App\Registry;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegistryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Registry  $registry
     * @return mixed
     */
    public function view(User $user, Registry $registry)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Registry  $registry
     * @return mixed
     */
    public function update(User $user, Registry $registry)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Registry  $registry
     * @return mixed
     */
    public function delete(User $user, Registry $registry)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Registry  $registry
     * @return mixed
     */
    public function restore(User $user, Registry $registry)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Registry  $registry
     * @return mixed
     */
    public function forceDelete(User $user, Registry $registry)
    {
        //
    }
}
