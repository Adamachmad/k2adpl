<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk mengakses halaman ini.');
        }

        // Pastikan pengguna memiliki role 'admin'
        // Ingat, nilai role di DB Anda adalah 'admin' (bukan 'user' atau 'dinas' untuk admin)
        if (Auth::user()->role === 'admin') {
            return $next($request); // Izinkan akses jika admin
        }

        // Jika bukan admin, redirect ke halaman utama dengan pesan error
        return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}