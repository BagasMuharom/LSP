<?php

namespace App\Http\Middleware;

use Closure;
use Storage;
use GlobalAuth;

class CheckPersyaratanLengkap
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
        $mhs = GlobalAuth::user();

        if (is_null($mhs->dir_ktp) || !Storage::exists($mhs->dir_ktp) ||
        is_null($mhs->dir_foto) || !Storage::exists($mhs->dir_foto) ||
        is_null($mhs->dir_transkrip) || !Storage::exists($mhs->dir_transkrip)) {
            return redirect()->route('pengaturan.akun')->with([
                'message' => 'Harap mengunggah KTP, Foto (Background merah), dan transkrip terbaru agar dapat menggunakan aplikasi dan melakukan pendaftaran.'
            ]);
        }

        return $next($request);
    }
}
