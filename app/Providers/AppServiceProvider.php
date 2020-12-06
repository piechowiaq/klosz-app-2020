<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

use function view;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('user.nav', static function ($view): void {
            $user = Auth::user();

            $view->with('user', $user);
        });
    }
}
