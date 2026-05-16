<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ✅ Daftarkan middleware alias is_petugas (Laravel 11+)
        // Untuk Laravel 10 ke bawah, gunakan Kernel.php yang sudah disediakan.
        $middleware->alias([
            'is_petugas' => \App\Http\Middleware\IsPetugas::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
