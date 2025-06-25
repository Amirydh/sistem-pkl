<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckProfileCompletion
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Cek jika user adalah peserta dan profilnya belum ada
        if ($user && $user->role === 'peserta' && $user->peserta === null) {
            
            // Izinkan akses HANYA ke halaman untuk membuat profil dan logout
            if (!$request->routeIs('peserta.profile.create') && !$request->routeIs('logout')) {
                // Jika mencoba akses halaman lain, paksa ke halaman lengkapi profil
                return redirect()->route('peserta.profile.create')->with('warning', 'Harap lengkapi profil Anda terlebih dahulu.');
            }
        }

        return $next($request);
    }
}