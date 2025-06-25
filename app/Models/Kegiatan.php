<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'peserta_id',
        'tanggal',
        'judul_kegiatan',
        'deskripsi',
        'foto',
        'status',
        'feedback_pembimbing',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    // ===================================================================
    // ==         TAMBAHKAN KODE INI UNTUK MEMPERBAIKI ERROR              ==
    // ===================================================================
    protected $casts = [
        'tanggal' => 'date',
    ];
    // ===================================================================
    // ==                       AKHIR KODE TAMBAHAN                       ==
    // ===================================================================

    /**
     * Get the peserta that owns the kegiatan.
     */
    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }
}