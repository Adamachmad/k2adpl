<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DinasMiddleware
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

        // Pastikan pengguna memiliki role 'dinas'
        if (Auth::user()->role === 'dinas') {
            return $next($request); // Izinkan akses jika dinas
        }

        // Jika bukan dinas, redirect ke halaman utama dengan pesan error
        return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman dinas.');
    }
}