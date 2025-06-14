<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman detail untuk laporan tertentu.
     */
    public function show($id): View
    {
        // LANGKAH 1: Buat data laporan statis (database palsu)
        // Nanti ini akan kita ganti dengan pengambilan data dari database asli.
        $reports = [
            1 => [
                'id' => 1,
                'title' => 'Pencemaran Laut Pulau Kabaena',
                'category' => 'Pencemaran Air',
                'location' => 'Bombana, Sulawesi Tenggara',
                'image_url' => 'https://cdn.builder.io/api/v1/image/assets/0768043069504c41ad969a9315e48cf8/70495b491d493198a97b72ca55f1c7d45672ae57?placeholderIfAbsent=true&format=webp&width=800',
                'description' => 'Terjadi tumpahan minyak dari kapal tongkang yang menyebabkan pencemaran di sepanjang pantai Pulau Kabaena, membahayakan ekosistem terumbu karang.',
                'reporter' => 'Warga Lokal',
                'date' => '13 Juni 2025',
                'status' => 'Aktif',
                'status_class' => 'active'
            ],
            2 => [
                'id' => 2,
                'title' => 'Penggundulan Hutan Liar Wawonii',
                'category' => 'Deforestasi',
                'location' => 'Konawe Kepulauan, Sulawesi Tenggara',
                'image_url' => 'https://cdn.builder.io/api/v1/image/assets/0768043069504c41ad969a9315e48cf8/624e7fcaf2f3148b658fbab940f49a9390432f27?placeholderIfAbsent=true&format=webp&width=800',
                'description' => 'Aktivitas penebangan pohon ilegal skala besar terdeteksi di kawasan hutan lindung Wawonii. Diperlukan tindakan segera untuk menghentikan kerusakan lebih lanjut.',
                'reporter' => 'Ani P.',
                'date' => '10 Juni 2025',
                'status' => 'Diproses',
                'status_class' => 'processing'
            ],
            3 => [
                'id' => 3,
                'title' => 'Pembuangan Limbah Padi Tongauna',
                'category' => 'Pencemaran Tanah',
                'location' => 'Konawe, Sulawesi Tenggara',
                'image_url' => 'https://cdn.builder.io/api/v1/image/assets/0768043069504c41ad969a9315e48cf8/7c8a0ad64e23c77aba14a983cb0c44b9f3efd777?placeholderIfAbsent=true&format=webp&width=800',
                'description' => 'Limbah sisa penggilingan padi dibuang sembarangan di lahan kosong dekat area pertanian, menimbulkan bau tidak sedap dan mencemari tanah sekitar.',
                'reporter' => 'Petani Lokal',
                'date' => '05 Juni 2025',
                'status' => 'Selesai',
                'status_class' => 'completed'
            ],
            4 => [
                'id' => 4,
                'title' => 'Polusi Smelter PT VDNI',
                'category' => 'Pencemaran Udara',
                'location' => 'Konawe, Sulawesi Tenggara',
                'image_url' => 'https://cdn.builder.io/api/v1/image/assets/0768043069504c41ad969a9315e48cf8/8ec9bb7dfb0b27b3c9bc530655a4e010361d6844?placeholderIfAbsent=true&format=webp&width=800',
                'description' => 'Asap tebal dan debu dari cerobong smelter PT VDNI seringkali menyelimuti desa-desa sekitar, menyebabkan gangguan pernapasan pada warga.',
                'reporter' => 'Budi S.',
                'date' => '12 Juni 2025',
                'status' => 'Aktif',
                'status_class' => 'active'
            ],
        ];

        // LANGKAH 2: Cari laporan berdasarkan ID yang diklik
        // Jika tidak ditemukan, tampilkan halaman error 404
        $report = $reports[$id] ?? null;
        if (!$report) {
            abort(404);
        }

        // LANGKAH 3: Kirim data laporan yang ditemukan ke view 'reports.show'
        return view('reports.show', compact('report'));
    }
}