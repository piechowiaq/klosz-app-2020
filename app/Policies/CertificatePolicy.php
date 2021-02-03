<?php

declare(strict_types=1);

namespace App\Policies;

use App\Certificate;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CertificatePolicy
{
    use HandlesAuthorization;

    public function after(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can view any certificates.
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->isManager() || $user->isUser();
    }

    /**
     * Determine whether the user can view the certificate.
     *
     * @return mixed
     */
    public function view(User $user, Certificate $certificate)
    {
        return $user->getCompanies()->contains($certificate->getCompany()->first()) && ($user->isAdmin() || $user->isManager() || $user->isUser());
    }

    /**
     * Determine whether the user can create certificates.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->isManager() || $user->isUser();
    }

    /**
     * Determine whether the user can update the certificate.
     *
     * @return mixed
     */
    public function update(User $user, Certificate $certificate)
    {
        return $user->isAdmin() || $user->isManager() || $user->isUser();
    }

    /**
     * Determine whether the user can delete the certificate.
     *
     * @return mixed
     */
    public function delete(User $user, Certificate $certificate)
    {
        return $user->isAdmin() || $user->isManager() || $user->isUser();
    }

    /**
     * Determine whether the user can restore the certificate.
     *
     * @return mixed
     */
    public function restore(User $user, Certificate $certificate)
    {
    }

    /**
     * Determine whether the user can permanently delete the certificate.
     *
     * @return mixed
     */
    public function forceDelete(User $user, Certificate $certificate)
    {
    }
}
