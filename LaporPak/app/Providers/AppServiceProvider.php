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
     * 
     * Catatan untuk Laravel 11+:
     * Middleware alias didaftarkan di bootstrap/app.php, bukan Kernel.php.
     * Lihat file bootstrap/app.php.
     */
    public function boot(): void
    {
    \Illuminate\Pagination\Paginator::useTailwind();
    }
}
