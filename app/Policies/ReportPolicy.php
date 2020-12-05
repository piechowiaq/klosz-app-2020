<?php

declare(strict_types=1);

namespace App\Policies;

use App\Report;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

use function in_array;

class ReportPolicy
{
    private const BASIC_ROLES = [
        'SuperAdmin',
        'Admin',
        'Manager',
        'User',
    ];
    private const ADMIN_ROLES = [
        'Manager',
        'Admin',
    ];
    use HandlesAuthorization;

    public function view(User $user, Report $report): bool
    {
        foreach ($user->getRoles() as $role) {
            if (in_array($role->getName(), self::BASIC_ROLES)) {
                return true;
            }
        }

        return false;
    }

    public function update(User $user, Report $report): bool
    {
        foreach ($user->getRoles() as $role) {
            if (in_array($role->getName(), self::ADMIN_ROLES)) {
                return true;
            }
        }

        return false;
    }
}
