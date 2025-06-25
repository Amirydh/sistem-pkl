<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika user tidak login atau tidak punya role yang diizinkan
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
            // Redirect ke halaman yang sesuai, atau tampilkan 403 Forbidden
            // Opsi: Redirect ke dashboard jika sudah login tapi role salah
            if (Auth::check()) {
                return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
            // Redirect ke login jika belum login
            return redirect('login');
        }
        
        return $next($request);
    }
}