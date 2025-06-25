<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KegiatanController extends Controller
{

    public function index()
    {
        $pembimbingId = Auth::user()->pembimbing->id;

        // Ambil semua kegiatan dari peserta yang dibimbing oleh pembimbing ini
        $kegiatans = Kegiatan::whereHas('peserta', function ($query) use ($pembimbingId) {
            $query->where('pembimbing_id', $pembimbingId);
        })
            ->with('peserta.user') // Load relasi untuk menampilkan nama peserta
            ->latest() // Urutkan dari yang terbaru
            ->paginate(15);

        return view('pembimbing.kegiatan.index', compact('kegiatans'));
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
