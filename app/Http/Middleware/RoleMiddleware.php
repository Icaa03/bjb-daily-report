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
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userRole = Auth::user()->role;

        // 2. Bersihkan kedua string (Ubah ke huruf kecil semua & hapus spasi jika ada)
        // Contoh: 'Pemimpin KCP' -> 'pemimpinkcp', 'pemimpin' -> 'pemimpin'
        $cleanUserRole = strtolower(str_replace(' ', '', $userRole));
        $cleanParamRole = strtolower(str_replace(' ', '', $role));

        // 3. TOLERANSI TOTAL: Jika parameter rute adalah 'pemimpin' DAN role user di DB adalah 'pemimpinkcp'
        if ($cleanParamRole === 'pemimpin' && $cleanUserRole === 'pemimpinkcp') {
            return $next($request);
        }

        // Cek kecocokan murni setelah dibersihkan
        if ($cleanUserRole !== $cleanParamRole) {
            abort(403, 'AKSES DITOLAK. HANYA PEMIMPIN KCP YANG DAPAT MEMVALIDASI LAPORAN.');
        }

        return $next($request);
    }
}