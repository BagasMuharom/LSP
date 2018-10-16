<?php

namespace App\Http\Controllers\Pages;

use App\Models\Uji;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Support\Facades\GlobalAuth;

class PenilaianPageController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth:user'
        ]);
    }

    /**
     * Menampilkan daftar uji yang berkaitan dengan asesor tertentu
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->filterStatus($request)
            ->when($request->q, function ($query) use ($request) {
                $query->where('nim', $request->q);
                $query->orWhereHas('getMahasiswa', function ($query) use ($request) {
                    $query->where('nama', 'ILIKE', "%{$request->q}%");
                });
            })
            ->paginate(10)
            ->appends($request->only('q'));
            
        return view('menu.penilaian.index', [
            'data' => $data,
            'q' => $request->q
        ]);
    }

    private function filterStatus(Request $request)
    {
        $data = GlobalAuth::user()->getUjiAsAsesor();

        if ($request->status == 0 || $request->status == null) {
            // dalam proses penilaian, artinya, uji yang belum asesmen diri oleh asesor
            // atau belum dinilai, atau belum dikonfirmasi
            $data->where(function ($query) {
                $query->where(function ($query) {
                    $query->filterByStatus(Uji::MENGISI_ASESMEN_DIRI);
                })->orWhere(function ($query) {
                    $query->filterByStatus(Uji::LULUS_ASESMEN_DIRI);
                })->orWhere(function ($query) {
                    $query->filterByStatus(Uji::PROSES_PENILAIAN);
                })->orWhere(function ($query) {
                    $query->filterByStatus(Uji::TIDAK_LULUS_ASESMEN_DIRI)
                        ->where('konfirmasi_asesmen_diri', false);
                });
            });
        } else if ($request->status == 1) {
            // Lulus Sertifikasi maupun hingga memiliki sertifikat
            $data->where(function ($query) {
                $query->where(function ($query) {
                    $query->filterByStatus(Uji::LULUS);
                })->orWhere(function ($query) {
                    $query->filterByStatus(Uji::MEMILIKI_SERTIFIKAT);
                });
            });
        } else if ($request->status == 2) {
            // tidak lulus sertifikasi
            $data->where(function ($query) {
                $query->where(function ($query) {
                    $query->filterByStatus(Uji::TIDAK_LULUS);
                });
            });
        } else if ($request->status == 3) {
            // tidak lulus asesmen diri
            $data->where(function ($query) {
                $query->where(function ($query) {
                    $query->filterByStatus(Uji::TIDAK_LULUS_ASESMEN_DIRI);
                });
            });
        }

        return $data;
    }

    /**
     * Menampilkan halaman penilaian untuk uji tertentu
     *
     * @param \App\Models\Uji $uji
     * @return \Illuminate\Http\Response
     */
    public function nilai(Uji $uji)
    {
        return view('menu.penilaian.nilai', [
            'uji' => $uji
        ]);
    }
}
