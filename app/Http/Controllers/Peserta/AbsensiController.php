<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AbsensiController extends Controller
{
    /**
     * Halaman BARU untuk menampilkan riwayat absensi.
     */
    public function index()
    {
        $peserta = Auth::user()->peserta;
        if (!$peserta->pembimbing_id) {
            return redirect()->route('peserta.dashboard')->with('warning', 'Anda belum memiliki pembimbing. Tidak dapat mengakses riwayat absensi.');
        }

        $riwayatAbsensi = Absensi::where('peserta_id', Auth::user()->peserta->id)
            ->latest('tanggal_absensi')
            ->paginate(15); // Paginasi untuk riwayat yang panjang

        return view('peserta.absensi.index', compact('riwayatAbsensi'));
    }

    /**
     * Halaman untuk menampilkan form absensi (SEKARANG LEBIH SEDERHANA).
     */
    public function create()
    {
        // Tidak perlu lagi mengambil data riwayat di sini
        return view('peserta.absensi.create');
    }

    /**
     * Menyimpan data absensi (UBAH REDIRECT).
     */
    public function store(Request $request)
    {
        // ... (kode validasi dan simpan tetap sama) ...
        $pesertaId = Auth::user()->peserta->id;

        $request->validate([
            'tanggal_absensi' => [
                'required', 'date',
                Rule::unique('absensis')->where('peserta_id', $pesertaId)
            ],
            'status' => ['required', Rule::in(['Hadir', 'Sakit', 'Izin'])],
            'keterangan' => 'required_if:status,Sakit,Izin|nullable|string',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        
        $pathBukti = null;
        if ($request->hasFile('bukti')) {
            $pathBukti = $request->file('bukti')->store('bukti-absensi', 'public');
        }

        Absensi::create([
            'peserta_id' => $pesertaId,
            'tanggal_absensi' => $request->tanggal_absensi,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'bukti' => $pathBukti,
        ]);

        // Redirect ke halaman riwayat agar user melihat hasilnya
        return redirect()->route('peserta.absensi.index')->with('success', 'Absensi berhasil disimpan.');
    }
}