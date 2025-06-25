<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\LokasiPkl;
use App\Models\Pembimbing;
use App\Models\Peserta;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Data Statistik Utama
        $totalPeserta = Peserta::count();
        $totalPembimbing = Pembimbing::count();
        $totalLokasi = LokasiPkl::count();
        $kegiatanMenungguCount = Kegiatan::where('status', 'menunggu persetujuan')->count();

        // Data untuk Feed "Aktivitas Terbaru" (5 user terakhir)
        $aktivitasTerbaru = User::whereIn('role', ['peserta', 'pembimbing'])
            ->latest()
            ->take(5)
            ->get();

        // Data untuk "Perlu Tindakan" (5 peserta dengan kegiatan menunggu)
        $pesertaMenungguValidasi = Peserta::whereHas('kegiatans', function ($query) {
                $query->where('status', 'menunggu persetujuan');
            })
            ->with('user')
            ->withCount(['kegiatans as kegiatan_menunggu_count' => function ($query) {
                $query->where('status', 'menunggu persetujuan');
            }])
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPeserta',
            'totalPembimbing',
            'totalLokasi',
            'kegiatanMenungguCount',
            'aktivitasTerbaru',
            'pesertaMenungguValidasi'
        ));
    }
}