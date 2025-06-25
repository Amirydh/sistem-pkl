<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromArray; // <-- Gunakan FromArray
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // <-- Untuk lebar kolom otomatis

class MyProfileExport implements FromArray, WithHeadings, ShouldAutoSize
{
    protected $user;

    // Terima objek user yang sedang login saat kelas ini dibuat
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Mendefinisikan header kolom.
     *
     * @return array
     */
    public function headings(): array
    {
        $headings = [
            'Nama Lengkap',
            'Email',
            'Peran (Role)',
            'Tanggal Bergabung',
        ];
        
        // Tambahkan header khusus jika user adalah peserta
        if ($this->user->role === 'peserta' && $this->user->peserta) {
            $headings = array_merge($headings, [
                'NISN',
                'Asal Sekolah / Kampus',
                'Kelas',
                'Jurusan',
                'Telepon Peserta',
                'Nama Pembimbing',
                'Lokasi PKL'
            ]);
        }

        // Tambahkan header khusus jika user adalah pembimbing
        if ($this->user->role === 'pembimbing' && $this->user->pembimbing) {
            $headings = array_merge($headings, [
                'NIP',
                'Jurusan Pembimbing',
                'Telepon Pembimbing'
            ]);
        }

        return $headings;
    }

    /**
     * Menyusun data untuk diekspor sebagai array.
     *
     * @return array
     */
    public function array(): array
    {
        $data = [
            $this->user->name,
            $this->user->email,
            $this->user->role,
            $this->user->created_at->format('d-m-Y'),
        ];
        
        // Tambahkan data khusus jika user adalah peserta
        if ($this->user->role === 'peserta' && $this->user->peserta) {
            $data = array_merge($data, [
                $this->user->peserta->nisn,
                $this->user->peserta->asal_sekolah,
                $this->user->peserta->kelas,
                $this->user->peserta->jurusan,
                $this->user->peserta->telepon,
                $this->user->peserta->pembimbing?->user?->name, // Menggunakan nullsafe
                $this->user->peserta->lokasiPkl?->nama_tempat,  // Menggunakan nullsafe
            ]);
        }

        // Tambahkan data khusus jika user adalah pembimbing
        if ($this->user->role === 'pembimbing' && $this->user->pembimbing) {
            $data = array_merge($data, [
                $this->user->pembimbing->nip,
                $this->user->pembimbing->jurusan,
                $this->user->pembimbing->telepon,
            ]);
        }

        // Return dalam bentuk array 2D karena hanya ada satu baris data
        return [
            $data
        ];
    }
}