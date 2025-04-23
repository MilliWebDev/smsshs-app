<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        // Defines admin gate
        Gate::define('admin-access', function ($user) {
            // Check if the user's role is 'admin'
            return $user->role === 'admin';
        });

    }
}
