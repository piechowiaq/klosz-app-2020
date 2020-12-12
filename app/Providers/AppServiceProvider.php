<?php

declare(strict_types=1);

namespace App\Providers;

use App\Core\Department\Domain\Repository\DepartmentRepositoryInterface;
use App\Core\Department\Infrastructure\Repository\EloquentDepartmentRepository;
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
