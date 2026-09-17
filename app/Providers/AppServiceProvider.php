<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\KontakKami;

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
        // Register role alias middleware so controllers can use middleware('role:...')
        $this->app['router']->aliasMiddleware('role', \App\Http\Middleware\CheckRole::class);

        // Share kontak_kami data with layouts.app
        View::composer('layouts.app', function ($view) {
            $view->with('kontak_kami', KontakKami::first());
        });
    }
}
