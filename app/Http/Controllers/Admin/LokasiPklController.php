<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LokasiPkl;
use Illuminate\Http\Request;

class LokasiPklController extends Controller
{
    public function index()
    {
        $lokasiPkls = LokasiPkl::latest()->paginate(10);
        return view('admin.lokasi-pkl.index', compact('lokasiPkls'));
    }

    public function create()
    {
        return view('admin.lokasi-pkl.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_tempat' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
        ]);

        LokasiPkl::create($validated);

        return redirect()->route('admin.lokasi-pkl.index')->with('success', 'Lokasi PKL berhasil ditambahkan.');
    }

    public function show(LokasiPkl $lokasiPkl)
    {
        // Muat relasi peserta untuk ditampilkan di halaman detail
        $lokasiPkl->load('pesertas.user');
        return view('admin.lokasi-pkl.show', compact('lokasiPkl'));
    }

    public function edit(LokasiPkl $lokasiPkl)
    {
        return view('admin.lokasi-pkl.edit', compact('lokasiPkl'));
    }

    public function update(Request $request, LokasiPkl $lokasiPkl)
    {
        $validated = $request->validate([
            'nama_tempat' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
        ]);

        $lokasiPkl->update($validated);

        return redirect()->route('admin.lokasi-pkl.index')->with('success', 'Lokasi PKL berhasil diperbarui.');
    }

    public function destroy(LokasiPkl $lokasiPkl)
    {
        // Relasi onDelete('set null') akan menangani foreign key di tabel peserta
        $lokasiPkl->delete();

        return redirect()->route('admin.lokasi-pkl.index')->with('success', 'Lokasi PKL berhasil dihapus.');
    }
}