<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Tambahkan kolom boolean 'is_approved_by_admin' setelah kolom 'status'
            // Defaultnya false, artinya laporan baru belum disetujui admin
            $table->boolean('is_approved_by_admin')->default(false)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Hapus kolom 'is_approved_by_admin' jika migrasi di-rollback
            $table->dropColumn('is_approved_by_admin');
        });
    }
};