<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $pembimbing = Auth::user()->pembimbing;

        // Ambil daftar peserta bimbingan dengan jumlah kegiatannya yang masih menunggu
        $pesertas = $pembimbing->pesertas()
            ->with('user')
            ->withCount(['kegiatans as kegiatan_menunggu_count' => function ($query) {
                $query->where('status', 'menunggu persetujuan');
            }])
            ->paginate(10);
            
        return view('pembimbing.dashboard', compact('pembimbing', 'pesertas'));
    }
}