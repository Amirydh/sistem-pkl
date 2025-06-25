<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'peserta_id',
        'tanggal_absensi',
        'status',
        'keterangan',
        'bukti',
    ];

    // Casting agar 'tanggal_absensi' selalu menjadi objek Carbon
    protected $casts = [
        'tanggal_absensi' => 'date',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }
}