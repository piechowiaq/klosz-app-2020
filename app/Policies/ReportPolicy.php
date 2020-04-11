<?php

namespace App\Policies;

use App\Report;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Report $report)
    {
        foreach ($user->roles()->get() as $role)
        {
            if ($role->name == 'SuperAdmin' || $role->name == 'Admin' ||$role->name == 'Manager' ||  $role->name == 'User' )
            {
                return true;
            }
        }
        return false;
    }


    public function update(User $user, Report $report)
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
}
