<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Pastikan ini ada
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerUser(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Validasi input dari form
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', Rule::in(['user', 'dinas'])],
        ]);

        // Buat pengguna baru, hash password secara manual
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password), // <<< PASTIKAN HASH::MAKE DI SINI
            'role' => $request->role,
        ]);

        // Langsung login pengguna setelah registrasi
        Auth::login($user);

        // Arahkan ke halaman beranda setelah registrasi sukses
        return redirect()->route('home')->with('success', 'Akun Anda berhasil dibuat!');
    }
}