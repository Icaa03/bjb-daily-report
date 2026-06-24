<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login atau belum
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek apakah role user sesuai dengan role yang diizinkan masuk halaman
        if (Auth::user()->role !== $role) {
            abort(403, 'Maaf Anisa, akun ini tidak memiliki hak akses untuk membuka halaman ini.');
        }

        return $next($request);
    }
}