<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use str_slug;
use SebastianBergmann\LinesOfCode\IllogicalValuesException;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function exportProfile()
    {
        $user = Auth::user();
        $photoPath = '';

        // Cek apakah user punya foto profil & file-nya benar-benar ada di disk
        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            $photoPath = Storage::disk('public')->path($user->profile_photo_path);
        } else {

            // Jika tidak ada foto profil, gunakan foto default
            $photoPath = public_path('images/default-profile.svg');
        }
        $type = pathinfo($photoPath, PATHINFO_EXTENSION);
        $data = file_get_contents($photoPath);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        // Siapkan data untuk dikirim ke view
        $data = [
            'user' => $user,
            'photoPath' => $base64, // Kirim path fisik ini
        ];

        // Buat PDF
        $pdf = PDF::loadView('profile.card', $data);
        $fileName = 'kartu-profil-' . Str::slug($user->name) . '.pdf';

        return $pdf->stream($fileName);
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */


    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // == LOGIKA UPLOAD FOTO PROFIL ==
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            // Simpan foto baru dan update path di database
            $user->profile_photo_path = $request->file('photo')->store('profile-photos', 'public');
        }
        // == AKHIR LOGIKA UPLOAD ==

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
