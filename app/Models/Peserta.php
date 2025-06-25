<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pembimbing_id',
        'lokasi_pkl_id',
        'nisn',
        'asal_sekolah',
        'kelas',
        'jurusan',
        'telepon',
    ];

    // Profil peserta ini milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Peserta ini dibimbing oleh satu pembimbing
    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class);
    }

    // Peserta ini ditempatkan di satu lokasi
    public function lokasiPkl()
    {
        return $this->belongsTo(LokasiPkl::class);
    }

    // Satu peserta memiliki banyak kegiatan
    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class);
    }
}