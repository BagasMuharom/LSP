<?php

namespace App\Support\Filter;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Uji;
use App\Models\Role;
use Auth;

trait UjiFilter {

    /**
     * Melakukan filter
     *
     * @param Request $request
     * @param Builder|HasMany $uji
     * @param int $defaultStatus
     * @return Builder
     */
    private function simplifyFilter(Request $request, $uji, $defaultStatus)
    {
        if ($request->has('status')) {
            $uji = $this->filterByStatus($request, $uji);
        }
        else {
            $request->status = $defaultStatus;
            $uji = $this->filterByStatus($request, $uji);
        }

        if ($request->has('keyword') and !empty($request->keyword)) {
            $uji = $this->filterByKeyword($request, $uji);
        }

        if ($request->has('skema') and $request->skema != -1) {
            $uji = $this->filterBySkema($request, $uji);
        }

        return $uji;
    }

    /**
     * Mendapatkan daftar uji dengan status tertentu
     * Daftar status :
     * 0 -> Belum terverifikasi
     * 1 -> terverfikasi
     * 2 -> ditolak
     * 3 -> terverifikasi admin
     * 4 -> terverifikasi bagian sertifikasi
     * 5 -> ditolak admin
     * 6 -> ditolak bagian sertifikasi
     * 7 -> semua
     * 8 -> telah mengisi asesmen diri
     *
     * @param Request $request
     * @param Builder|HasMany $uji
     * @return Uji
     */
    private function filterByStatus(Request $request, $uji)
    {
        $status = null;

        if ($request->status == 0) {
            if (Auth::user()->hasRole(Role::ADMIN))
                $status = Uji::BELUM_DIVERIFIKASI_ADMIN;
            else if (Auth::user()->hasRole(Role::SERTIFIKASI))
                $status = Uji::BELUM_DIVERIFIKASI_BAG_SERTIFIKASI;
            else
                $status = Uji::BELUM_DIVERIFIKASI;
        }
        else if ($request->status == 1) {
            if (Auth::user()->hasRole(Role::ADMIN))
                $status = Uji::TERVERIFIKASI_ADMIN;
            else if (Auth::user()->hasRole(Role::SERTIFIKASI))
                $status = Uji::TERVERIFIKASI_BAG_SERTIFIKASI;
        }
        else if ($request->status == 2) {
            if (Auth::user()->hasRole(Role::ADMIN))
                $status = Uji::DITOLAK_ADMIN;
            else if (Auth::user()->hasRole(Role::SERTIFIKASI))
                $status = Uji::DITOLAK_BAG_SERTIFIKASI;
        }
        else if ($request->status == 3) {
            $status = Uji::TERVERIFIKASI_ADMIN;
        }
        else if ($request->status == 4) {
            $status = Uji::TERVERIFIKASI_BAG_SERTIFIKASI;
        }
        else if ($request->status == 5) {
            $status = Uji::DITOLAK_ADMIN;
        }
        else if ($request->status == 6) {
            $status = Uji::DITOLAK_BAG_SERTIFIKASI;
        }
        else if ($request->status == 8) {
            $status = Uji::MENGISI_ASESMEN_DIRI;
        }
        else if ($request->status == 9) {
            $status = Uji::BELUM_MEMILIKI_ASESOR;
        }
        else if ($request->status == 10) {
            $status = Uji::BELUM_DINILAI;
        }
        else if ($request->status == 11) {
            $status = Uji::LULUS;
        }
        else if ($request->status == 12) {
            $status = Uji::MEMILIKI_SERTIFIKAT;
        }
        else if ($request->status == 13) {
            $status = Uji::BELUM_MEMILIKI_TANGGAL_UJI;
        }
        else if ($request->status == 14) {
            $status = Uji::PROSES_PENILAIAN;
        }
        else if ($request->status == 15) {
            $status = Uji::TIDAK_LULUS;
        }
        else if ($request->status == 16) {
            $status = Uji::TIDAK_LANJUT_ASESMEN;
        }
        else if ($request->status == 17) {
            $status = Uji::LULUS_ASESMEN_DIRI;
        }
        else if ($request->status == 18) {
            $status = Uji::TIDAK_LULUS_ASESMEN_DIRI;
        }

        if (!is_null($status))
            $uji = $uji->filterByStatus($status);

        return $uji;
    }

    /**
     * Melakukan filter berdasarkan keyword (nama atau nim)
     *
     * @param Request $request
     * @param Builder|HasMany $uji
     * @return uji
     */
    private function filterByKeyword(Request $request, $uji)
    {
        return $uji->where(function ($query) use ($request) {
                $query->where('nim', $request->keyword)
                    ->orWhereHas('getMahasiswa', function ($query) use ($request) {
                        $query->where('nama', 'ILIKE', '%' . $request->keyword . '%');
                    });
            });
    }

    /**
     * Melakukan filter berdasarkan skema
     *
     * @param Request $request
     * @param Builder|HasMany $uji
     * @return Uji
     */
    private function filterBySkema(Request $request, $uji)
    {
        return $uji->whereHas('getEvent.getSkema', function ($query) use ($request) {
            $query->where('id', $request->skema);
        });
    }

}