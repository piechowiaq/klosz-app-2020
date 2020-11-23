<?php

namespace App\Policies;

use App\Certificate;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CertificatePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Certificate $certificate)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

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

    public function delete(User $user, Certificate $certificate)
    {
        //
    }

    public function restore(User $user, Certificate $certificate)
    {
        //
    }

    public function forceDelete(User $user, Certificate $certificate)
    {
        //
    }
}
