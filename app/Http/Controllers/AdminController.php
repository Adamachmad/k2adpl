<?php

namespace App\Http\Controllers;

use App\Models\Report; // <<< PASTIKAN INI DI-IMPORT UNTUK MENGAKSES MODEL REPORT
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse; // Pastikan ini di-import untuk return type
use Illuminate\Support\Facades\Auth; // Pastikan ini di-import jika menggunakan Auth::user()

class AdminController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin.
     * @return \Illuminate\View\View
     */
    public function dashboard(): View
    {
        // Contoh data untuk dashboard admin
        // Pastikan Anda sudah menjalankan migrasi untuk tabel reports dan kolom is_approved_by_admin
        $totalReports = Report::count();
        $pendingApprovalReports = Report::where('is_approved_by_admin', false)->count();
        $dinasReports = Report::where('is_approved_by_admin', true)->count();
        $completedReports = Report::where('status', 'SELESAI')->count();

        return view('admin.dashboard', compact('totalReports', 'pendingApprovalReports', 'dinasReports', 'completedReports'));
    }

    /**
     * Menampilkan daftar artikel edukasi untuk dikelola.
     * @return \Illuminate\View\View
     */
    public function educationIndex(): View
    {
        // Nanti di sini kita akan mengambil artikel dari database
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

    /**
     * Menampilkan daftar laporan yang menunggu persetujuan admin.
     * @return \Illuminate\View\View
     */
    public function pendingApprovalReports(): View
    {
        // Mengambil semua laporan yang belum disetujui admin
        $reports = Report::where('is_approved_by_admin', false)
                         ->latest() // Urutkan dari yang terbaru
                         ->paginate(10); // Dengan paginasi

        return view('admin.reports.pending_approval', compact('reports'));
    }

    /**
     * Menyetujui laporan oleh admin.
     * Mengubah is_approved_by_admin menjadi true.
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveReport($id): RedirectResponse
    {
        // Cari laporan berdasarkan ID, jika tidak ada, otomatis 404
        $report = Report::findOrFail($id);
        $report->is_approved_by_admin = true; // Set status persetujuan ke true
        $report->save(); // Simpan perubahan

        return redirect()->route('admin.reports.pending_approval')->with('status', 'Laporan berhasil disetujui dan diteruskan ke dinas!');
    }

    /**
     * Menolak laporan oleh admin (opsional).
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectReportByAdmin($id): RedirectResponse
    {
        // Cari laporan berdasarkan ID, jika tidak ada, otomatis 404
        $report = Report::findOrFail($id);
        $report->is_approved_by_admin = false; // Tetapkan status persetujuan ke false (atau bisa juga mengubah status utamanya)
        $report->save(); // Simpan perubahan

        return redirect()->route('admin.reports.pending_approval')->with('status', 'Laporan berhasil ditolak oleh admin.');
    }
}