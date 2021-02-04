<?php

declare(strict_types=1);

namespace App\Providers;

use App\Core\Company\Domain\Repository\CompanyRepositoryInterface;
use App\Core\Company\Infrastructure\Repository\EloquentCompanyRepository;
use App\Core\Department\Domain\Repository\DepartmentRepositoryInterface;
use App\Core\Department\Infrastructure\Repository\EloquentDepartmentRepository;
use App\Core\Example\Domain\Factory\SampleModelFactoryInterface;
use App\Core\Example\Domain\Repository\ExampleRepositoryInterface;
use App\Core\Example\Infrastructure\Factory\SampleModelFactory;
use App\Core\Example\Infrastructure\Repository\ExampleRepository;
use App\Core\Registry\Domain\Repository\RegistryRepositoryInterface;
use App\Core\Registry\Infrastructure\Repository\EloquentRegistryRepository;
use App\Core\Role\Domain\Repository\RoleRepositoryInterface;
use App\Core\Role\Infrastructure\Repository\EloquentRoleRepository;
use App\Core\Training\Domain\Repository\TrainingRepositoryInterface;
use App\Core\Training\Infrastructure\Repository\EloquentTrainingRepository;
use App\Shared\Db\Db;
use App\Shared\Db\DbInterface;
use App\Shared\Http\Response\ResponseFactory;
use App\Shared\Http\Response\ResponseFactoryInterface;
use App\Shared\MessageBus\MessageBus;
use App\Shared\MessageBus\MessageBusInterface;
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
        $this->app->bind(CompanyRepositoryInterface::class, EloquentCompanyRepository::class);
        $this->app->bind(RegistryRepositoryInterface::class, EloquentRegistryRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, EloquentRoleRepository::class);
        $this->app->bind(TrainingRepositoryInterface::class, EloquentTrainingRepository::class);

        // Example
        $this->app->bind(ExampleRepositoryInterface::class, ExampleRepository::class);
        $this->app->bind(SampleModelFactoryInterface::class, SampleModelFactory::class);

        // SHARED
        $this->app->bind(MessageBusInterface::class, MessageBus::class);
        $this->app->bind(ResponseFactoryInterface::class, ResponseFactory::class);
        $this->app->bind(DbInterface::class, Db::class);
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
