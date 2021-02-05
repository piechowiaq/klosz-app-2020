<?php

declare(strict_types=1);

namespace App\Policies;

use App\Employee;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
{
    use HandlesAuthorization;

    public function after(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can view any employees.
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->isManager() || $user->isUser();
    }

    /**
     * Determine whether the user can view the employee.
     *
     * @return mixed
     */
    public function view(User $user, Employee $employee)
    {
        return $user->getCompanies()->contains($employee->getCompany()->first()) && $user->isAdmin() || $user->isManager() || $user->isUser();
    }

    /**
     * Determine whether the user can create employees.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->isManager();
    }

    /**
     * Determine whether the user can update the employee.
     *
     * @return mixed
     */
    public function update(User $user, Employee $employee)
    {
          return $user->getCompanies()->contains($employee->getCompany()->first()) && $user->isAdmin() || $user->isManager();
    }

    /**
     * Determine whether the user can delete the employee.
     *
     * @return mixed
     */
    public function delete(User $user, Employee $employee)
    {
        $user->getCompanies()->contains($employee->getCompany()->first()) && $user->isAdmin() || $user->isManager();
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
