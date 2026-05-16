<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsPetugas
{
    /**
     * Handle an incoming request.
     * Hanya user dengan role 'petugas' yang boleh lewat.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role !== 'petugas') {
            return redirect('/dashboard')->with('error', 'Akses ditolak. Halaman ini hanya untuk petugas.');
        }

        return $next($request);
    }
}
