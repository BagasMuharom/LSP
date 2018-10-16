<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Uji, Role};
use Carbon\Carbon;
use Auth;

class VerifikasiController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:user');
        $this->middleware('can:verifikasi,' . Uji::class);
    }

    /**
     * Menerima pendaftaran
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function terima(Request $request, Uji $uji)
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole(Role::ADMIN);
        $isSertifikasi = $user->hasRole(Role::SERTIFIKASI);
        $isSuperAdmin = $user->hasRole(Role::SUPER_ADMIN);

        if ($isAdmin or ($isSuperAdmin and $request->has('auth') and $request->auth == 'admin')) {
            $uji->update([
                'admin_id' => $user->id,
                'terverifikasi_admin' => true,
                'updated_at' => Carbon::now()
            ]);
        }

        if ($isSertifikasi or ($isSuperAdmin and $request->has('auth') and $request->auth == 'sertifikasi')) {
            $uji->update([
                'bag_sertifikasi_id' => $user->id,
                'terverifikasi_bag_sertifikasi' => true,
                'updated_at' => Carbon::now()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil melakukan verifikasi !'
        ]);
    }

    /**
     * Menolak pendaftaran
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function tolak(Request $request, Uji $uji)
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole(Role::ADMIN);
        $isSertifikasi = $user->hasRole(Role::SERTIFIKASI);
        $isSuperAdmin = $user->hasRole(Role::SUPER_ADMIN);

        if ($isAdmin or ($isSuperAdmin and $request->has('auth') and $request->auth == 'admin')) {
            $uji->update([
                'admin_id' => $user->id,
                'terverifikasi_admin' => false,
                'catatan' => $request->catatan
            ]);
        }

        if ($isSertifikasi or ($isSuperAdmin and $request->has('auth') and $request->auth == 'sertifikasi')) {
            $uji->update([
                'bag_sertifikasi_id' => $user->id,
                'terverifikasi_bag_sertifikasi' => false,
                'catatan' => $request->catatan
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil melakukan penolakan !'
        ]);
    }

    /**
     * Menghapus atau mereset field untuk verifikasi
     *
     * @param Request $request
     * @param Uji $uji
     * @return \Illuminate\Http\Response
     */
    public function hapus(Request $request, Uji $uji)
    {
        $uji->update([
            'admin_id' => null,
            'terverifikasi_admin' => null,
            'bag_sertifikasi_id' => null,
            'terverifikasi_bag_sertifikasi' => null,
            'catatan' => null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mereset verifikasi !'
        ]);
    }

}
