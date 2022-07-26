<?php

namespace App\Providers;

use App\Charts\RegistryChart;
use App\Charts\TrainingChart;
use App\Training;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('user.nav',function($view){

            $user = Auth::user();

            $view->with('user', $user );

        });





    }
}
