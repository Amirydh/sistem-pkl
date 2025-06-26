<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo_path', // <-- 1. Tambahkan ini ke fillable
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    // 2. Tambahkan appends agar accessor selalu disertakan
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string 
     */
    // 3. Buat Accessor untuk mendapatkan URL foto profil
   public function getProfilePhotoBase64Attribute()
{
    if ($this->profile_photo_path && Storage::disk('public')->exists($this->profile_photo_path)) {
        $path = storage_path('app/public/' . $this->profile_photo_path);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
    // fallback ke SVG default
    return $this->defaultProfilePhotoUrl();
}

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    // 4. Method untuk menghasilkan SVG default
    protected function defaultProfilePhotoUrl()
    {
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        // SVG dasar dengan siluet pengguna
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>';

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function pembimbing()
    {
        return $this->hasOne(Pembimbing::class);
    }

    // Relasi one-to-one ke profil peserta
    public function peserta()
    {
        return $this->hasOne(Peserta::class);
    }
}