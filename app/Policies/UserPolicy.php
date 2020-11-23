<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function view(User $user)
    {

        {
            if ($user->companies()->count()>1 || $user->isSuperAdmin())
            {
                return true;
            }
        }
        return false;
    }
}
