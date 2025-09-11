<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Custom API route registration (adjust path as needed)

        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        //Default web router registaration 
        Route::middleware('web')
        ->group(base_path('routes/web.php'));
    }
}
