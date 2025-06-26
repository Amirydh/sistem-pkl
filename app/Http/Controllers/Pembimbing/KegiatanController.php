<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KegiatanController extends Controller
{

    public function index(Request $request)
    {
        $pembimbingId = Auth::user()->pembimbing->id;

        // Jika ada filter peserta, tampilkan hanya kegiatan peserta tersebut
        if ($request->has('peserta')) {
            $peserta = Peserta::with('user')->where('id', $request->peserta)
                ->where('pembimbing_id', $pembimbingId)
                ->firstOrFail();
            $kegiatans = $peserta->kegiatans()->with('peserta.user')->latest()->paginate(15);
            // Kirim juga $peserta ke view jika ingin highlight/filter
            return view('pembimbing.kegiatan.index', compact('kegiatans', 'peserta'));
        }

        // Default: semua kegiatan dari peserta bimbingan
        $kegiatans = Kegiatan::whereHas('peserta', function ($query) use ($pembimbingId) {
            $query->where('pembimbing_id', $pembimbingId);
        })
            ->with('peserta.user')
            ->latest()
            ->paginate(15);

        $pesertas = Peserta::with('user')
            ->where('pembimbing_id', $pembimbingId)
            ->orderBy('asal_sekolah')
            ->paginate(10);

        return view('pembimbing.kegiatan.index', compact('kegiatans', 'pesertas'));
    }

    // Menampilkan daftar kegiatan dari satu peserta
    public function show(Peserta $peserta)
    {
        // Validasi: pastikan peserta ini adalah bimbingan dari pembimbing yang login
        $pembimbingId = Auth::user()->pembimbing->id;
        abort_if($peserta->pembimbing_id !== $pembimbingId, 403);

        $kegiatans = $peserta->kegiatans()->orderBy('tanggal', 'desc')->paginate(10);
        return view('pembimbing.kegiatan.show', compact('peserta', 'kegiatans')); // Buat view ini
    }

    // Method untuk memvalidasi (setuju/tolak) sebuah kegiatan
    public function validasi(Request $request, Kegiatan $kegiatan)
    {
        // Validasi: pastikan kegiatan ini milik peserta yang dibimbingnya
        $pembimbingId = Auth::user()->pembimbing->id;
        abort_if($kegiatan->peserta->pembimbing_id !== $pembimbingId, 403);

        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'feedback_pembimbing' => 'nullable|string',
        ]);

        $kegiatan->update([
            'status' => $request->status,
            'feedback_pembimbing' => $request->feedback_pembimbing,
        ]);

        return back()->with('success', 'Kegiatan telah divalidasi.');
    }
}
