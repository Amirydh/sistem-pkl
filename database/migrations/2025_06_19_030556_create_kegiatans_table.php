<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            // Relasi dengan peserta
            $table->foreignId('peserta_id')->constrained()->onDelete('cascade');
            
            $table->date('tanggal');
            $table->string('judul_kegiatan');
            $table->text('deskripsi');
            $table->string('foto')->nullable(); // Menyimpan path ke file foto
            $table->enum('status', ['menunggu persetujuan', 'disetujui', 'ditolak'])->default('menunggu persetujuan');
            $table->text('feedback_pembimbing')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};