<?php

namespace App\Policies;

use App\Employee;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class EmployeePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Employee $employee)
    {
        foreach ($user->roles()->get() as $role)
        {
            if ($role->name == 'SuperAdmin' || $role->name == 'Admin' || $role->name == 'Manager' || $role->name == 'User' )
            {
                return true;
            }
        }
        return false;
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Employee $employee)
    {
        foreach ($user->roles()->get() as $role)
        {
            if ($role->name == 'SuperAdmin' || $role->name == 'Admin' || $role->name == 'Manager')
            {
                return true;
            }
        }
        return false;
    }

    public function delete(User $user, Employee $employee)
    {
        //
    }

    public function restore(User $user, Employee $employee)
    {
        //
    }

    public function forceDelete(User $user, Employee $employee)
    {
        //
    }
}
