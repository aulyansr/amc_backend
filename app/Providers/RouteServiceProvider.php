<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Hashids\Hashids;
class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/admin/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
            Route::middleware('web')
                ->prefix('admin')
                ->group(base_path('routes/web.php'));

                Route::middleware('customer')
                ->group(base_path('routes/customer.php'));

                Route::middleware('technician')
                ->prefix('technician')
                ->group(base_path('routes/technician.php'));
        });
        Route::bind('customer', function ($value) {
            $hashids = new Hashids('amc', 10, 'abcdefghijklmnopqrstuvwxyz1234567890');
            $decodedIds = $hashids->decode($value);
            if (count($decodedIds) > 0) {
                return $decodedIds[0];
            }
            return null;
        });
        Route::bind('ordercustomer', function ($value) {
            $hashids = new Hashids('amc', 10, 'abcdefghijklmnopqrstuvwxyz1234567890');
            $decodedIds = $hashids->decode($value);
            if (count($decodedIds) > 0) {
                return $decodedIds[0];
            }
            return null;
        });
        Route::bind('cdata', function ($value) {
            $hashids = new Hashids('amc', 10, 'abcdefghijklmnopqrstuvwxyz1234567890');
            $decodedIds = $hashids->decode($value);
            if (count($decodedIds) > 0) {
                return $decodedIds[0];
            }
            return null;
        });

    }
}
