<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pembimbing;
use App\Models\Peserta;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Gunakan transaksi untuk memastikan semua data berhasil dibuat
        DB::transaction(function () {
            // 1. Buat User Admin
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);

            // 2. Buat User Pembimbing beserta profilnya
            $pembimbingUser = User::create([
                'name' => 'Pembimbing User',
                'email' => 'pembimbing@example.com',
                'password' => Hash::make('password'),
                'role' => 'pembimbing',
                'email_verified_at' => now(),
            ]);

            $pembimbingUser->pembimbing()->create([
                'nip' => '198010102010011001',
                'jurusan' => 'Teknik Komputer dan Jaringan',
                'telepon' => '081234567891',
            ]);

            // 3. Buat User Peserta beserta profilnya
            $pesertaUser = User::create([
                'name' => 'Peserta User',
                'email' => 'peserta@example.com',
                'password' => Hash::make('password'),
                'role' => 'peserta',
                'email_verified_at' => now(),
            ]);

            $pesertaUser->peserta()->create([
                'nisn' => '0012345678',
                'asal_sekolah' => 'SMK Negeri 1 Contoh',
                'kelas' => 'XII TKJ 1',
                'jurusan' => 'Teknik Komputer dan Jaringan',
                'telepon' => '089876543210',
                // Anda bisa assign pembimbing_id jika sudah ada pembimbing lain
                // 'pembimbing_id' => $pembimbingUser->pembimbing->id, 
            ]);
        });
    }
}