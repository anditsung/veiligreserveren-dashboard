<?php

namespace App\Providers;

use App\Http\Controllers\LoginController;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Http\Controllers\LoginController as NovaLoginController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NovaLoginController::class, LoginController::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
