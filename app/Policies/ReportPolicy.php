<?php

declare(strict_types=1);

namespace App\Policies;

use App\Report;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return mixed
     */
    public function update(User $user, Report $report)
    {
        return $user->getCompanies()->contains($report->getCompany()->first()) && $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return mixed
     */
    public function delete(User $user, Report $report)
    {
        return $user->getCompanies()->contains($report->getCompany()->first()) && $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return mixed
     */
    public function restore(User $user, Report $report)
    {
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return mixed
     */
    public function forceDelete(User $user, Report $report)
    {
    }
}
