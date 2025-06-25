<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembimbing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'jurusan',
        'telepon',
    ];

    // Profil pembimbing ini milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Satu pembimbing bisa membimbing banyak peserta
    public function pesertas()
    {
        return $this->hasMany(Peserta::class);
    }
}