<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Education; // Tambahkan model Education
use App\Models\User;      // Tambahkan model User
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Untuk menghapus file

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin.
     * @return \Illuminate\View\View
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
     * Menampilkan daftar laporan yang menunggu persetujuan admin.
     * @return \Illuminate\View\View
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
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveReport($id): RedirectResponse
    {
        $report = Report::findOrFail($id);
        $report->is_approved_by_admin = true;
        $report->save();

        return redirect()->route('admin.reports.pending_approval')->with('status', 'Laporan berhasil disetujui dan diteruskan ke Dinas!');
    }

    /**
     * Menolak laporan oleh admin.
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectReportByAdmin($id): RedirectResponse
    {
        $report = Report::findOrFail($id);
        // Tambahkan logika penolakan jika diperlukan (misalnya, menambahkan catatan penolakan)
        $report->delete(); // Atau set status ke "DITOLAK" jika Anda tidak ingin menghapus permanen

        return redirect()->route('admin.reports.pending_approval')->with('status', 'Laporan berhasil ditolak.');
    }

    // ====================== EDUKASI =========================

    /**
     * Menampilkan daftar artikel edukasi.
     * @return \Illuminate\View\View
     */
    public function educationIndex(): View
    {
        $articles = Education::latest()->paginate(10);
        return view('admin.education.index', compact('articles'));
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
     * Menyimpan artikel edukasi baru ke database.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeEducation(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = $request->file('image')->store('education', 'public');

        Education::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.education.index')->with('status', 'Artikel edukasi berhasil dibuat!');
    }

    /**
     * Menampilkan form untuk mengedit artikel edukasi.
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function editEducation($id): View
    {
        $article = Education::findOrFail($id);
        return view('admin.education.edit', compact('article'));
    }

    /**
     * Mengupdate artikel edukasi di database.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEducation(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $article = Education::findOrFail($id);

        $article->title = $request->title;
        $article->content = $request->content;

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($article->image) {
                Storage::delete('public/' . $article->image);
            }
            $imagePath = $request->file('image')->store('education', 'public');
            $article->image = $imagePath;
        }

        $article->save();

        return redirect()->route('admin.education.index')->with('status', 'Artikel edukasi berhasil diperbarui!');
    }

    /**
     * Menghapus artikel edukasi dari database.
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyEducation($id): RedirectResponse
    {
         $article = Education::findOrFail($id);

        // Hapus gambar terkait jika ada
        if ($article->image) {
            Storage::delete('public/' . $article->image);
        }

        $article->delete();

        return redirect()->route('admin.education.index')->with('status', 'Artikel edukasi berhasil dihapus!');
    }

    // ====================== PENGGUNA =========================

    /**
     * Menampilkan daftar pengguna.
     * @return \Illuminate\View\View
     */
    public function userIndex(): View
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan detail pengguna.
     * @param int $id
     * @return \Illuminate\View\View
     */
     public function showUser($id): View
     {
         $user = User::findOrFail($id);
         return view('admin.users.show', compact('user'));
     }

    /**
     * Menghapus pengguna.
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyUser($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'Pengguna berhasil dihapus!');
    }
}