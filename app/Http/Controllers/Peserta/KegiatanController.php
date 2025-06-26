<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    // Menampilkan semua kegiatan milik peserta yang login
    public function index()
    {
        $peserta = Auth::user()->peserta;
        if (!$peserta->pembimbing_id ){
            return redirect()->route('peserta.dashboard')->with('warning', 'Anda belum memiliki pembimbing. Tidak dapat mengakses kegiatan.');
        }
        $kegiatans = Auth::user()->peserta->kegiatans()->orderBy('tanggal', 'desc')->paginate(10);
        return view('peserta.kegiatan.index', compact('kegiatans')); // Anda perlu membuat view ini
    }

    // Menampilkan form untuk membuat kegiatan baru
    public function create()
    {
        $peserta = Auth::user()->peserta;
        if (!$peserta->pembimbing_id) {
            return redirect()->route('peserta.dashboard')->with('warning', 'Anda belum memiliki pembimbing. Tidak dapat mengisi kegiatan.');
        }
        return view('peserta.kegiatan.create'); // Anda perlu membuat view ini
    }

    // Menyimpan kegiatan baru
    public function store(Request $request)
    {
        $peserta = Auth::user()->peserta;
        if (!$peserta->pembimbing_id) {
            return redirect()->route('peserta.dashboard')->with('warning', 'Anda belum memiliki pembimbing. Tidak dapat mengisi kegiatan.');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'judul_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);

        $pathFoto = null;
        if ($request->hasFile('foto')) {
            // Simpan foto ke storage/app/public/kegiatan-foto
            $pathFoto = $request->file('foto')->store('kegiatan-foto', 'public');
        }

        Auth::user()->peserta->kegiatans()->create([
            'tanggal' => $request->tanggal,
            'judul_kegiatan' => $request->judul_kegiatan,
            'deskripsi' => $request->deskripsi,
            'foto' => $pathFoto,
        ]);

        return redirect()->route('peserta.kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit kegiatan
    public function edit(Kegiatan $kegiatan)
    {
        // Pastikan peserta hanya bisa mengedit kegiatannya sendiri
        abort_if($kegiatan->peserta_id !== Auth::user()->peserta->id, 403);

        return view('peserta.kegiatan.edit', compact('kegiatan')); // Anda perlu membuat view ini
    }

    // Mengupdate kegiatan
    public function update(Request $request, Kegiatan $kegiatan)
    {
        // Pastikan peserta hanya bisa mengupdate kegiatannya sendiri
        abort_if($kegiatan->peserta_id !== Auth::user()->peserta->id, 403);

        $request->validate([
            'tanggal' => 'required|date',
            'judul_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $pathFoto = $kegiatan->foto;
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($kegiatan->foto) {
                Storage::disk('public')->delete($kegiatan->foto);
            }
            $pathFoto = $request->file('foto')->store('kegiatan-foto', 'public');
        }

        $kegiatan->update([
            'tanggal' => $request->tanggal,
            'judul_kegiatan' => $request->judul_kegiatan,
            'deskripsi' => $request->deskripsi,
            'foto' => $pathFoto,
        ]);

        return redirect()->route('peserta.kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    // Menghapus kegiatan
    public function destroy(Kegiatan $kegiatan)
    {
        // Pastikan peserta hanya bisa menghapus kegiatannya sendiri
        abort_if($kegiatan->peserta_id !== Auth::user()->peserta->id, 403);

        // Hapus foto dari storage
        if ($kegiatan->foto) {
            Storage::disk('public')->delete($kegiatan->foto);
        }

        $kegiatan->delete();

        return redirect()->route('peserta.kegiatan.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
