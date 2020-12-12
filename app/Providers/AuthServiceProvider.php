<?php

declare(strict_types=1);

namespace App\Providers;

use App\Certificate;
use App\Employee;
use App\Policies\CertificatePolicy;
use App\Policies\EmployeePolicy;
use App\Policies\ReportPolicy;
use App\Policies\UserPolicy;
use App\Report;
use App\User;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array|mixed[]|string[]
     */
    protected $policies = [

        Employee::class => EmployeePolicy::class,
        Certificate::class => CertificatePolicy::class,
        Report::class => ReportPolicy::class,
        User::class => UserPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(Gate $gate): void
    {
        $this->registerPolicies();

        $gate->before(static function (User $user) {
            return $user->isSuperAdmin();
        });
    }
}
