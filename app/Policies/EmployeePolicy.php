<?php

declare(strict_types=1);

namespace App\Policies;

use App\Employee;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any employees.
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
    }

    /**
     * Determine whether the user can view the employee.
     *
     * @return mixed
     */
    public function view(User $user, Employee $employee)
    {
        foreach ($user->roles()->get() as $role) {
            if ($role->name === 'SuperAdmin' || $role->name === 'Admin' || $role->name === 'Manager' || $role->name === 'User') {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can create employees.
     *
     * @return mixed
     */
    public function create(User $user)
    {
    }

    /**
     * Determine whether the user can update the employee.
     *
     * @return mixed
     */
    public function update(User $user, Employee $employee)
    {
        foreach ($user->roles()->get() as $role) {
            if ($role->name === 'SuperAdmin' || $role->name === 'Admin' || $role->name === 'Manager') {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can delete the employee.
     *
     * @return mixed
     */
    public function delete(User $user, Employee $employee)
    {
    }

    /**
     * Determine whether the user can restore the employee.
     *
     * @return mixed
     */
    public function restore(User $user, Employee $employee)
    {
    }

    /**
     * Determine whether the user can permanently delete the employee.
     *
     * @return mixed
     */
    public function forceDelete(User $user, Employee $employee)
    {
    }
}
