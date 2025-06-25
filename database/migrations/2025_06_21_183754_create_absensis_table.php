<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_absensis_table.php
public function up(): void
{
    Schema::create('absensis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('peserta_id')->constrained()->onDelete('cascade');
        $table->date('tanggal_absensi');
        $table->enum('status', ['Hadir', 'Sakit', 'Izin']);
        $table->text('keterangan')->nullable(); // Untuk alasan Sakit/Izin
        $table->string('bukti')->nullable(); // Untuk menyimpan path file surat dokter, dll.
        $table->timestamps();

        // Mencegah peserta absen lebih dari sekali di tanggal yang sama
        $table->unique(['peserta_id', 'tanggal_absensi']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
