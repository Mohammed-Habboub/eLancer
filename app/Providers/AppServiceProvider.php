<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
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
        // Method 1 | Config Facades : Give me information about folder config (set|get)
        /* if (Config::get('app.env') == 'production') {
            Config::set('app.debug', false);
        } */

        // Method 2 | App Facades : Give me information about the Application and service container
        if (App::environment('production')) {
            config::set('app.debug', false);
        }

        Paginator::useBootstrap();
    }
}
