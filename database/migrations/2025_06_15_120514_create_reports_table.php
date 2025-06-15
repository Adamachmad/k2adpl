<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
{
    Schema::create('reports', function (Blueprint $table) {
        $table->id(); // Ini adalah 'laporanId' Anda

        // Kolom ini menghubungkan setiap laporan ke seorang user.
        // Jika user dihapus, semua laporannya juga akan ikut terhapus (onDelete('cascade')).
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

        $table->string('judul');
        $table->text('deskripsi');
        $table->string('lokasi');
        $table->string('fotoBukti'); // Kita akan simpan path/nama file fotonya di sini

        // Kolom 'status' dengan nilai default 'DITUNDA' sesuai diagram Anda
        $table->enum('status', ['DITUNDA', 'DISETUJUI', 'DITOLAK', 'DIPROSES', 'SELESAI'])->default('DITUNDA');

        // Ini sudah mencakup 'laporanDibuat' (created_at) dan 'tanggalUpdate' (updated_at)
        $table->timestamps(); 
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
};
