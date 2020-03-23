<?php

namespace App\Policies;

use App\Certificate;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CertificatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any certificates.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the certificate.
     *
     * @param  \App\User  $user
     * @param  \App\Certificate  $certificate
     * @return mixed
     */
    public function view(User $user, Certificate $certificate)
    {
        //
    }

    /**
     * Determine whether the user can create certificates.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the certificate.
     *
     * @param  \App\User  $user
     * @param  \App\Certificate  $certificate
     * @return mixed
     */
    public function update(User $user, Certificate $certificate)
    {
        foreach ($user->roles()->get() as $role)
        {
            if ($role->name == 'Manager' || $role->name == 'Admin' )
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can delete the certificate.
     *
     * @param  \App\User  $user
     * @param  \App\Certificate  $certificate
     * @return mixed
     */
    public function delete(User $user, Certificate $certificate)
    {
        //
    }

    /**
     * Determine whether the user can restore the certificate.
     *
     * @param  \App\User  $user
     * @param  \App\Certificate  $certificate
     * @return mixed
     */
    public function restore(User $user, Certificate $certificate)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the certificate.
     *
     * @param  \App\User  $user
     * @param  \App\Certificate  $certificate
     * @return mixed
     */
    public function forceDelete(User $user, Certificate $certificate)
    {
        //
    }
}
