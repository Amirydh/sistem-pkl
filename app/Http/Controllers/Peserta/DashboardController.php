<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $peserta = Auth::user()->peserta;
        
        $kegiatanTerbaru = $peserta->kegiatans()
            ->latest()
            ->take(5)
            ->get();
            
        $totalKegiatan = $peserta->kegiatans()->count();
        $kegiatanDisetujui = $peserta->kegiatans()->where('status', 'disetujui')->count();
        $kegiatanMenunggu = $peserta->kegiatans()->where('status', 'menunggu persetujuan')->count();

        return view('peserta.dashboard', compact(
            'peserta',
            'kegiatanTerbaru',
            'totalKegiatan',
            'kegiatanDisetujui',
            'kegiatanMenunggu'
        ));
    }
}