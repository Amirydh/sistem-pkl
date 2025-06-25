<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LokasiPkl;
use App\Models\Pembimbing;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class PesertaController extends Controller
{
    public function index()
    {
        $pesertas = Peserta::with(['user', 'pembimbing.user', 'lokasiPkl'])->latest()->paginate(10);
        return view('admin.peserta.index', compact('pesertas'));
    }

    public function create()
    {
        $pembimbings = Pembimbing::with('user')->get();
        $lokasiPkls = LokasiPkl::all();
        return view('admin.peserta.create', compact('pembimbings', 'lokasiPkls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nisn' => 'required|string|max:255|unique:pesertas',
            'asal_sekolah' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'pembimbing_id' => 'nullable|exists:pembimbings,id',
            'lokasi_pkl_id' => 'nullable|exists:lokasi_pkls,id',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'peserta',
            ]);

            $user->peserta()->create($request->except(['name', 'email', 'password', 'password_confirmation']));
        });

        return redirect()->route('admin.peserta.index')->with('success', 'Peserta berhasil ditambahkan.');
    }

    public function edit(Peserta $peserta)
{
    // Ambil SEMUA pembimbing untuk mengisi dropdown
    $pembimbings = Pembimbing::with('user')->get();
    
    $lokasiPkls = LokasiPkl::all();
    
    // Kirim data pembimbings ke view
    return view('admin.peserta.edit', compact('peserta', 'pembimbings', 'lokasiPkls'));
}

    public function update(Request $request, Peserta $peserta)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($peserta->user_id)],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'nisn' => ['required', 'string', 'max:255', Rule::unique('pesertas')->ignore($peserta->id)],
            'asal_sekolah' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'pembimbing_id' => 'nullable|exists:pembimbings,id',
            'lokasi_pkl_id' => 'nullable|exists:lokasi_pkls,id',
        ]);
        
        DB::transaction(function () use ($request, $peserta) {
            $peserta->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if ($request->filled('password')) {
                $peserta->user->update(['password' => Hash::make($request->password)]);
            }

            $peserta->update($request->except(['name', 'email', 'password', 'password_confirmation']));
        });

        return redirect()->route('admin.peserta.index')->with('success', 'Data peserta berhasil diperbarui.');
    }

    public function destroy(Peserta $peserta)
    {
        // Menghapus user akan otomatis menghapus profile peserta dan semua kegiatannya
        User::destroy($peserta->user_id);
        
        return redirect()->route('admin.peserta.index')->with('success', 'Peserta berhasil dihapus.');
    }
}