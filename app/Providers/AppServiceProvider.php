<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
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
    Paginator::useBootstrapFive();

    // Share message data with ALL admin views automatically
    view()->composer('admin.*', function ($view) {
        $view->with('messageCount', \App\Models\Contact::count());
        $view->with('recentMessages', \App\Models\Contact::latest()->take(5)->get());
    }); // <--- Added the closing ); here
}
}
