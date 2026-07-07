<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        \Illuminate\Support\Facades\Gate::define('baak', function ($user) {
            return $user->role === 'baak';
        });

        \Illuminate\Support\Facades\Gate::define('mahasiswa', function ($user) {
            return $user->role === 'mahasiswa';
        });
    }
}
