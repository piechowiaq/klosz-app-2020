<?php

namespace App\Providers;

use App\Certificate;
use App\Employee;
use App\Policies\EmployeePolicy;
use App\Policies\CertificatePolicy;
use App\Policies\ReportPolicy;
use App\Report;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [

        Employee::class => EmployeePolicy::class,
        Certificate::class => CertificatePolicy::class,
        Report::class => ReportPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @param Gate $gate
     * @return void
     */
    public function boot(Gate $gate)
    {
        $this->registerPolicies();

        $gate->before(function ($user) {

            if ($user->isSuperAdmin()) {
                return true;
            }

        });
    }
}
