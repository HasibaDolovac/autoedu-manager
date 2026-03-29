<?php

namespace App\Providers;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

   public function boot(): void
    {
       
        if (!app()->runningInConsole()) {
            View::composer('layouts.okvir', function ($view) {
                $view->with('svi_instruktori', User::where('role', 'instruktor')->get());
                $view->with('svi_kandidati', User::where('role', 'kandidat')->get());
            });

            View::share('svi_instruktori', User::where('role', 'instruktor')->get());
            View::share('svi_kandidati', User::where('role', 'kandidat')->get());
        }
    }
}
