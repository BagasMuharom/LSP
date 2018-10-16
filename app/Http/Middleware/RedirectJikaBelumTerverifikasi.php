<?php

namespace App\Http\Middleware;

use Closure;
use App\Support\Facades\GlobalAuth;

class RedirectJikaBelumTerverifikasi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (GlobalAuth::getAttemptedGuard() === 'user' or $request->user()->terverifikasi)
            return $next($request);

        return response()->view('mahasiswa.belum_terverifikasi');
    }
}
