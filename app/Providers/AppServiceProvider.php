<?php

declare(strict_types=1);

namespace App\Providers;

use App\Core\Certificate\Domain\Repository\CertificateRepositoryInterface;
use App\Core\Certificate\Infrastructure\Repository\EloquentCertificateRepository;
use App\Core\Company\Domain\Repository\CompanyRepositoryInterface;
use App\Core\Company\Infrastructure\Repository\EloquentCompanyRepository;
use App\Core\Department\Domain\Repository\DepartmentRepositoryInterface;
use App\Core\Department\Infrastructure\Repository\EloquentDepartmentRepository;
use App\Core\Registry\Domain\Repository\RegistryRepositoryInterface;
use App\Core\Registry\Infrastructure\Repository\EloquentRegistryRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DepartmentRepositoryInterface::class, EloquentDepartmentRepository::class);
        $this->app->bind(CertificateRepositoryInterface::class, EloquentCertificateRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, EloquentCompanyRepository::class);
        $this->app->bind(RegistryRepositoryInterface::class, EloquentRegistryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(View $view): void
    {
        View::composer('user.nav', static function ($view): void {
            $user = Auth::user();

            $view->with('user', $user);
        });
    }
}
