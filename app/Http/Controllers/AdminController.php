<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse; // Pastikan ini di-import untuk return type
use Illuminate\Support\Facades\Auth; // Pastikan ini di-import jika menggunakan Auth::user()

class AdminController
{
    /**
     * Menampilkan halaman dashboard admin.
     * @return \Illuminate\View\View
     */
    public function dashboard(): View
    {
        return view('admin.dashboard');
    }

    /**
     * Menampilkan daftar artikel edukasi untuk dikelola.
     * @return \Illuminate\View\View
     */
    public function educationIndex(): View
    {
        // Nanti di sini kita akan mengambil artikel dari database
        // Untuk sekarang, kita hanya menampilkan view kosong
        return view('admin.education.index');
    }

    /**
     * Menampilkan form untuk membuat artikel edukasi baru.
     * @return \Illuminate\View\View
     */
    public function createEducation(): View
    {
        return view('admin.education.create');
    }

    /**
     * Menyimpan artikel edukasi baru.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeEducation(Request $request): RedirectResponse
    {
        // Logika menyimpan artikel ke database (simulasi)
        return redirect()->route('admin.education.index')->with('status', 'Artikel berhasil ditambahkan (simulasi)!');
    }

    /**
     * Menampilkan form untuk mengedit artikel edukasi.
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function editEducation($id): View
    {
        // Ambil artikel berdasarkan $id (simulasi)
        return view('admin.education.edit', compact('id'));
    }

    /**
     * Memperbarui artikel edukasi.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEducation(Request $request, $id): RedirectResponse
    {
        // Logika memperbarui artikel di database (simulasi)
        return redirect()->route('admin.education.index')->with('status', 'Artikel berhasil diperbarui (simulasi)!');
    }

    /**
     * Menghapus artikel edukasi.
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyEducation($id): RedirectResponse
    {
        // Logika menghapus artikel dari database (simulasi)
        return redirect()->route('admin.education.index')->with('status', 'Artikel berhasil dihapus (simulasi)!');
    }
}