<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembimbing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class PembimbingController extends Controller
{
    public function index()
    {
        $pembimbings = Pembimbing::with('user')->latest()->paginate(10);
        return view('admin.pembimbing.index', compact('pembimbings'));
    }

    public function create()
    {
        return view('admin.pembimbing.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nip' => 'nullable|string|max:255|unique:pembimbings',
            'jurusan' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pembimbing',
            ]);

            $user->pembimbing()->create([
                'nip' => $request->nip,
                'jurusan' => $request->jurusan,
                'telepon' => $request->telepon,
            ]);
        });

        return redirect()->route('admin.pembimbing.index')->with('success', 'Pembimbing berhasil ditambahkan.');
    }

    public function edit(Pembimbing $pembimbing)
    {
        return view('admin.pembimbing.edit', compact('pembimbing'));
    }

    public function update(Request $request, Pembimbing $pembimbing)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($pembimbing->user_id)],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'nip' => ['nullable', 'string', 'max:255', Rule::unique('pembimbings')->ignore($pembimbing->id)],
            'jurusan' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
        ]);

        DB::transaction(function () use ($request, $pembimbing) {
            $pembimbing->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            
            if ($request->filled('password')) {
                $pembimbing->user->update([
                    'password' => Hash::make($request->password)
                ]);
            }

            $pembimbing->update([
                'nip' => $request->nip,
                'jurusan' => $request->jurusan,
                'telepon' => $request->telepon,
            ]);
        });
        
        return redirect()->route('admin.pembimbing.index')->with('success', 'Data pembimbing berhasil diperbarui.');
    }

    public function destroy(Pembimbing $pembimbing)
    {
        // onDelete('cascade') di migration akan menghapus profile pembimbing secara otomatis
        User::destroy($pembimbing->user_id);

        return redirect()->route('admin.pembimbing.index')->with('success', 'Pembimbing berhasil dihapus.');
    }
}