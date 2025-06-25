<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    // Menampilkan form untuk melengkapi profil
    public function create()
    {
        // Jika profil sudah ada, redirect ke dashboard
        if (Auth::user()->peserta) {
            return redirect()->route('dashboard');
        }
        return view('peserta.profile.create');
    }

    // Menyimpan data profil yang baru
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string|max:255|unique:pesertas',
            'asal_sekolah' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
        ]);

        Auth::user()->peserta()->create($request->all());

        return redirect()->route('dashboard')->with('success', 'Profil Anda berhasil disimpan!');
    }
}