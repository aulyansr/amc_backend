<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Indonesia;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
class IndonesiaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        if (Schema::hasTable('indonesia_provinces')) {
            $router = app(Router::class);
            $provinsi = Indonesia::allProvinces()->sortBy('name')->pluck('name', 'id');
            view()->share(compact('provinsi'));
        }
    }
}
