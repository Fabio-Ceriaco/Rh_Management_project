<?php

namespace App\Providers;

use App\Models\User;
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
        //=========================================
        // GATES
        //=========================================

        // define a gate that checks if the user is admin
        Gate::define('user_admin', function (User $user) {
            return $user->role === 'admin';
        });

        // define a gate that checks if the user is rh
        Gate::define('user_rh', function (User $user) {
            return $user->role === 'rh';
        });
        // define a gate that checks if the user is collaborator
        Gate::define('user_collaborator', function (User $user) {
            return $user->role === 'collaborator';
        });
    }
}
