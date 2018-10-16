<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;

class RedirectJikaTerblokir
{
    /**
     * Memastikan mahasiswa tidak terblokir
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() instanceof User)
            return $next($request);

        if (!$request->user('mhs')->terblokir)
            return $next($request);

        return response()->view('auth.terblokir');
    }
}
