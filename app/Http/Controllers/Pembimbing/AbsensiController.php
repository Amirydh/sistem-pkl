<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    /**
     * Menampilkan daftar semua absensi dari semua peserta bimbingan.
     */
    public function index()
    {
        $pembimbingId = Auth::user()->pembimbing->id;

        // Ambil semua data absensi dari peserta yang dibimbing oleh pembimbing ini
        $absensiLog = Absensi::whereHas('peserta', function ($query) use ($pembimbingId) {
                $query->where('pembimbing_id', $pembimbingId);
            })
            ->with('peserta.user') // Eager load untuk efisiensi query
            ->latest('tanggal_absensi') // Urutkan dari tanggal terbaru
            ->paginate(20); // Paginasi untuk data yang banyak

        return view('pembimbing.absensi.index', compact('absensiLog'));
    }
}