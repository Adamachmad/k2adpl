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
public function up()
{
    Schema::create('reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        $table->string('judul')->nullable(); // <-- Tambahkan ->nullable()
        $table->text('deskripsi')->nullable(); // <-- Tambahkan ->nullable()
        $table->text('lokasi')->nullable(); // <-- Tambahkan ->nullable()
        $table->json('fotoBukti')->nullable(); // <-- Ubah ke json() dan tambahkan ->nullable()

        // Kolom di bawah ini tidak perlu diubah
        $table->string('category');
        $table->string('status')->default('DRAFT');

        $table->timestamps();

        // Tambahan dari file Anda, ini sudah benar
        $table->boolean('is_approved_by_admin')->default(false); 
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
