<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    
    public function boot(): void
    {
        View::composer('menu.nav', function ($view) {
          
            $currentRoute = request()->route() ? request()->route()->getName() : '';
        
            $view->with('slug', $currentRoute);
        });
    }
}
