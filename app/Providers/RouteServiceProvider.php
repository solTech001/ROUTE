<?php

namespace App\Providers;

use Tamedevelopers\Route\Route;
use Tamedevelopers\Providers\ServiceProvider;


class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';


    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->routes(function () {
            
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('admin')
                ->group(base_path('routes/admin.php'));
        });
    }

}
