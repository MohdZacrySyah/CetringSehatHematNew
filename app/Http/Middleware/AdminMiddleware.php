<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek apakah role user adalah 'admin'
        // Asumsi: Kita sudah punya kolom 'role' di tabel users
        if (Auth::user()->role !== 'admin') {
            // Jika bukan admin, tendang ke halaman home user biasa
            // atau tampilkan error 403 (Forbidden)
            abort(403, 'AKSES DITOLAK: Halaman ini khusus Admin!');
        }

        // 3. Jika lolos semua cek, silakan lanjut
        return $next($request);
    }
}