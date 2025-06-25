<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiPkl extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_tempat',
        'alamat',
        'telepon',
    ];

    // Satu lokasi bisa memiliki banyak peserta
    public function pesertas()
    {
        return $this->hasMany(Peserta::class);
    }
}