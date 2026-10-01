<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekRole
{
    /**
     * Handle an incoming request.
     *
    public function handle(Request $request, Closure $next, ...$roles)
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Memeriksa apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Memeriksa apakah role pengguna ada di dalam daftar role yang diizinkan
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // Jika tidak memiliki akses
        abort(403, 'Akses Ditolak: Anda tidak memiliki hak akses ke halaman ini.');
    }
}