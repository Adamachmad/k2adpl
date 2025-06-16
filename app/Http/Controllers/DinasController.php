<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DinasController extends Controller
{
    /**
     * Menampilkan dashboard dinas dengan daftar laporan yang disetujui admin.
     * @return \Illuminate\View\View
     */
    public function dashboard(): View
    {
        // Mengambil laporan yang statusnya is_approved_by_admin = true
        // Tambahkan filter status jika diperlukan (misal hanya yang 'DITUNDA' atau 'DIPROSES')
        $reports = Report::where('is_approved_by_admin', true)
                         ->latest()
                         ->paginate(10); // Paginasi untuk daftar laporan

        return view('dinas.dashboard', compact('reports'));
    }

    /**
     * Menampilkan detail laporan untuk dinas.
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showReport($id): View|RedirectResponse
    {
        $report = Report::where('id', $id)
                        ->where('is_approved_by_admin', true) // Pastikan hanya laporan yang disetujui
                        ->firstOrFail(); // Jika tidak ditemukan, otomatis 404

        return view('dinas.show_report', compact('report'));
    }

    /**
     * Mengupdate status laporan oleh dinas.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateReportStatus(Request $request, $id): RedirectResponse
    {
        $report = Report::where('id', $id)
                        ->where('is_approved_by_admin', true) // Pastikan hanya laporan yang disetujui
                        ->firstOrFail();

        $request->validate([
            'status' => ['required', 'string', 'in:DITUNDA,DIPROSES,SELESAI,DITOLAK'], // Sesuaikan status yang valid
        ]);

        $report->status = $request->status;
        $report->save();

        return redirect()->route('dinas.dashboard')->with('status', 'Status laporan berhasil diperbarui!');
        // Atau kembali ke halaman detail:
        // return redirect()->route('dinas.show.report', $report->id)->with('status', 'Status laporan berhasil diperbarui!');
    }
}