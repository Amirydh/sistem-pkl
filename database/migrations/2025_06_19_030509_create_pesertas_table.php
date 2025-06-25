<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesertas', function (Blueprint $table) {
            $table->id();
            // Relasi one-to-one dengan tabel users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Relasi dengan pembimbing dan lokasi (bisa null jika belum di-assign)
            $table->foreignId('pembimbing_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('lokasi_pkl_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('nisn')->unique(); // Nomor Induk Siswa Nasional
            $table->string('asal_sekolah');
            $table->string('kelas');
            $table->string('jurusan');
            $table->string('telepon')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesertas');
    }
};