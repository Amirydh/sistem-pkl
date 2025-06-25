<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembimbing;
use App\Models\LokasiPkl;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenugasanController extends Controller
{
    /**
     * Menampilkan halaman penugasan.
     */
    public function index()
    {
        // Ambil semua data yang dibutuhkan untuk dropdown
        $pembimbings = Pembimbing::with('user')->get();
        $lokasiPkls = LokasiPkl::all();
        
        // Ambil semua peserta beserta relasi yang sudah ada
        $pesertas = Peserta::with('user', 'pembimbing', 'lokasiPkl')->get();

        return view('admin.penugasan.index', compact('pesertas', 'pembimbings', 'lokasiPkls'));
    }

    /**
     * Menyimpan perubahan penugasan secara massal.
     */
    public function store(Request $request)
    {
        // Validasi sederhana untuk memastikan data yang masuk adalah array
        $request->validate([
            'pembimbing_id' => 'sometimes|array',
            'lokasi_pkl_id' => 'sometimes|array',
        ]);

        try {
            // Gunakan transaksi untuk memastikan semua update berhasil atau tidak sama sekali
            DB::transaction(function () use ($request) {
                $pembimbingIds = $request->input('pembimbing_id', []);
                $lokasiPklIds = $request->input('lokasi_pkl_id', []);

                // Gabungkan semua ID peserta dari kedua input untuk di-loop
                $allPesertaIds = array_unique(array_merge(array_keys($pembimbingIds), array_keys($lokasiPklIds)));

                foreach ($allPesertaIds as $pesertaId) {
                    $peserta = Peserta::find($pesertaId);
                    if ($peserta) {
                        $peserta->update([
                            'pembimbing_id' => $pembimbingIds[$pesertaId] ?? null,
                            'lokasi_pkl_id' => $lokasiPklIds[$pesertaId] ?? null,
                        ]);
                    }
                }
            });

        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan dengan pesan kesalahan
            return redirect()->back()->with('error', 'Gagal menyimpan perubahan: ' . $e->getMessage());
        }

        return redirect()->route('admin.penugasan.index')->with('success', 'Perubahan penugasan berhasil disimpan!');
    }
}