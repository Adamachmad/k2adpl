<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Education;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin.
     */
    public function dashboard(): View
    {
        $totalReports = Report::count();
        $pendingApprovalReports = Report::where('is_approved_by_admin', false)->count();
        $dinasReports = Report::where('is_approved_by_admin', true)->count();
        $completedReports = Report::where('status', 'SELESAI')->count();

        return view('admin.dashboard', compact('totalReports', 'pendingApprovalReports', 'dinasReports', 'completedReports'));
    }

    /**
     * Menampilkan semua laporan untuk dikelola oleh Admin.
     */
    public function allReports(): View
    {
        // 'with('user')' adalah optimasi agar query lebih efisien (menghindari N+1 problem)
        $reports = Report::with('user')->latest()->paginate(15); 
        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Menampilkan daftar laporan yang menunggu persetujuan admin.
     */
    public function pendingApprovalReports(): View
    {
        $reports = Report::where('is_approved_by_admin', false)
                            ->latest()
                            ->paginate(10);
        return view('admin.reports.pending_approval', compact('reports'));
    }

    /**
     * Menyetujui laporan oleh admin.
     */
    public function approveReport($id): RedirectResponse
    {
        $report = Report::findOrFail($id);
        $report->is_approved_by_admin = true;
        $report->status = 'DIPROSES'; // Mengubah status saat disetujui
        $report->save();

        return redirect()->route('admin.reports.pending_approval')->with('status', 'Laporan berhasil disetujui dan diteruskan ke Dinas!');
    }

    /**
     * Menolak laporan oleh admin.
     */
    public function rejectReportByAdmin($id): RedirectResponse
    {
        $report = Report::findOrFail($id);
        // PERBAIKAN: Kode asli Anda menghapus laporan, yang lebih cocok untuk fungsi 'destroy'.
        // Di sini kita ubah statusnya saja agar lebih sesuai dengan aksi "Tolak".
        $report->status = 'DITOLAK';
        $report->save();

        return redirect()->route('admin.reports.pending_approval')->with('status', 'Laporan berhasil ditolak.');
    }

    /**
     * Menghapus laporan beserta file-fotonya secara permanen.
     */
    public function destroyReport(Report $report): RedirectResponse
    {
        // Langkah 1: Hapus file-foto dari storage jika ada
        if ($report->fotoBukti && is_array($report->fotoBukti)) {
            foreach ($report->fotoBukti as $photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
        }
        // Langkah 2: Hapus data laporan dari database
        $report->delete();

        // Langkah 3: Kembalikan admin ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('status', 'Laporan berhasil dihapus secara permanen.');
    }

    // ====================== EDUKASI (BAGIAN YANG DIPERBARUI) =========================

    /**
     * Menampilkan daftar artikel edukasi.
     */
    public function educationIndex(): View
    {
        $articles = Education::latest()->paginate(10);
        return view('admin.education.index', compact('articles'));
    }

    /**
     * Menampilkan form untuk membuat artikel edukasi baru.
     */
    public function createEducation(): View
    {
        return view('admin.education.create');
    }

    /**
     * Menyimpan artikel edukasi baru ke database.
     */
    public function storeEducation(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Simpan gambar dan dapatkan path-nya untuk disimpan ke database
            $validatedData['image'] = $request->file('image')->store('education-images', 'public');
        }

        Education::create($validatedData);

        return redirect()->route('admin.education.index')->with('status', 'Artikel edukasi berhasil dibuat!');
    }

    /**
     * Menampilkan form untuk mengedit artikel edukasi.
     */
    public function editEducation(Education $education): View
    {
        // Menggunakan Route Model Binding untuk mengambil data artikel secara otomatis
        return view('admin.education.edit', ['article' => $education]);
    }

    /**
     * Mengupdate artikel edukasi di database.
     */
    public function updateEducation(Request $request, Education $education): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada sebelum mengupload yang baru
            if ($education->image) {
                Storage::disk('public')->delete($education->image);
            }
            // Simpan gambar baru dan tambahkan path ke data yang akan diupdate
            $validatedData['image'] = $request->file('image')->store('education-images', 'public');
        }
        
        $education->update($validatedData);

        return redirect()->route('admin.education.index')->with('status', 'Artikel edukasi berhasil diperbarui!');
    }

    /**
     * Menghapus artikel edukasi dari database.
     */
    public function destroyEducation(Education $education): RedirectResponse
    {
        // Hapus gambar terkait jika ada
        if ($education->image) {
            Storage::disk('public')->delete($education->image);
        }

        $education->delete();

        return redirect()->route('admin.education.index')->with('status', 'Artikel edukasi berhasil dihapus!');
    }

    // ====================== PENGGUNA (KODE ASLI ANDA) =========================

    /**
     * Menampilkan daftar pengguna.
     */
    public function userIndex(): View
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan detail pengguna.
     */
    public function showUser($id): View
{
    // Menggunakan with('reports') untuk mengambil data user dan semua laporannya
    // sekaligus dalam satu query yang efisien.
    $user = User::with('reports')->findOrFail($id);

    return view('admin.users.show', compact('user'));
}

    /**
     * Menghapus pengguna.
     */
    public function destroyUser($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'Pengguna berhasil dihapus!');
    }
}
