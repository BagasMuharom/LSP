<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Contracts\Encryption\DecryptException;
use PDF;
use App\Models\Uji;
use App\Http\Controllers\Controller;
use App\Models\KomponenMak4;
use App\Support\Facades\GlobalAuth;
use function Matrix\trace;

class FormPageController extends Controller
{

    /**
     * Menyetak form pendaftaran
     *
     * @param Uji $uji
     * @return void
     */
    public function cetakFormPendaftaran(Uji $uji)
    {
        // return view('form.pendaftaran');
        $mahasiswa = $uji->getMahasiswa(false);
        $daftarSyarat = $uji->getSyaratUji(false);
        $persyaratan = $uji->getSkema(false)->getSyarat(false);
        $pdf = PDF::loadView('form.pendaftaran', [
            'mahasiswa' => $mahasiswa,
            'daftarSyarat' => $daftarSyarat,
            'skema' => $uji->getSkema(false),
            'persyaratan' => $persyaratan
        ]);
        $pdf->setPaper('A4');

        return $pdf->stream();
        // return view('form.pendaftaran', [
        //     'mahasiswa' => $mahasiswa,
        //     'daftarSyarat' => $daftarSyarat,
        //     'persyaratan' => $persyaratan,
        //     'skema' => $uji->getSkema(false)
        // ]);
    }

    /**
     * menyetak form APL 01
     *
     * @return mixed
     */
    public function cetakApl01(Uji $uji)
    {
        $persyaratan = $uji->getSkema(false)->getSyarat(false);

        $pdf = PDF::loadView('form.apl_01', [
            'uji' => $uji,
            'mahasiswa' => $uji->getMahasiswa(false),
            'skema' => $uji->getSkema(false),
            'persyaratan' => $persyaratan
        ]);

        // return view('form.apl_01', [
        //     'uji' => $uji,
        //     'mahasiswa' => $uji->getMahasiswa(false),
        //     'skema' => $uji->getSkema(false),
        //     'persyaratan' => $persyaratan
        // ]);

        return $pdf->stream();
    }

    /**
     * Mencetak asesmen diri
     *
     * @param Uji $uji  
     * @return \Illuminate\Http\Response
     */
    public function cetakApl02(Uji $uji)
    {
        $pdf = PDF::loadView('form.apl_02', [
            'uji' => $uji,
            'skema' => $uji->getSkema(false),
            'mahasiswa' => $uji->getMahasiswa(false),
            'asesmendiri' => $uji->getPenilaianDiri()
        ]);

        return $pdf->stream();
    }

    /**
     * Menyetak form APL 02 Versi 2
     *
     * @param \App\Models\Uji $uji
     * @return \Illuminate\Http\Response
     */
    public function cetakApl02V2(Uji $uji)
    {
        $pdf = PDF::loadView('form.apl_02_v2', [
            'uji' => $uji,
            'skema' => $uji->getSkema(false),
            'mahasiswa' => $uji->getMahasiswa(false)
        ]);

        return $pdf->stream();
    }

    /**
     * Menyetak form MAK 01
     *
     * @param \App\Support\EksporUji $uji
     * @return mixed
     */
    public function cetakMak01(Uji $uji)
    {
        // mendapatkan nilai per unit pada kolom helper di tabel uji
        $nilaiUnit = collect($uji->helper['nilai_unit']);

        // mendapatkan daftar tes yang bisa dilakukan 
        // contoh hasil : ['Tes Lisan', 'Tes Tertulis', ....]
        $daftarTes = collect($nilaiUnit->first())->keys();
        
        // untuk menyimpan daftar tes yang dilakukan pada saat pengujian
        $daftarTesYangDilakukan = [];

        foreach ($daftarTes as $namaTes) {
            $jumlahNamaTesYangDilakukan = $nilaiUnit->filter(function ($value) use ($namaTes) {
                return $value[$namaTes] !== null;
            })->count();

            if ($jumlahNamaTesYangDilakukan !== 0)
                $daftarTesYangDilakukan[] = $namaTes;
        }

        $pdf = PDF::loadView('form.mak_01', [
            'uji' => $uji,
            'skema' => $uji->getSkema(false),
            'daftarTesYangDilakukan' => $daftarTesYangDilakukan
        ]);

        // return view('form.mak_02', [
        //     'uji' => $uji,
        //     'skema' => $uji->getSkema(false)
        // ]);

        return $pdf->stream();
    }

    /**
     * menyetak form MAK 02
     *
     * @return mixed
     */
    public function cetakMak02(Uji $uji)
    {
        $pdf = PDF::loadView('form.mak_02', [
            'uji' => $uji,
            'skema' => $uji->getSkema(false)
        ]);

        // return view('form.mak_02', [
        //     'uji' => $uji,
        //     'skema' => $uji->getSkema(false)
        // ]);

        return $pdf->stream();
    }

    /**
     * Menyetak form MAK 04
     *
     * @param Uji $uji
     * @return void
     */
    public function cetakMak04(Uji $uji)
    {
        GlobalAuth::authorize('cetakMak04', $uji);

        $pdf = PDF::loadView('form.mak_04', [
            'isian' => collect($uji->helper['mak4']),
            'uji' => $uji,
            'daftarKomponen' => KomponenMak4::all()
        ]);

        return $pdf->stream();
    }

    /**
     * Menyetak form mak
     *
     * @param Uji $uji
     * @return mixed
     */
    public function cetakMpa02(Uji $uji)
    {
        $pdf = PDF::loadView('form.mpa02', [
            'uji' => $uji,
            'skema' => $uji->getSkema(false)
        ]);
        $pdf->setPaper('A4');

        // return view('form.mpa02', [
        //     'uji' => $uji,
        //     'skema' => $uji->getSkema(false)
        // ]);

        return $pdf->stream();
    }

    /**
     * Menyetak form FR AI 02
     *
     * @param \App\Models\Uji $uji
     * @return mixed
     */
    public function cetakFRAI02(Uji $uji)
    {
        $pdf = PDF::loadView('form.fr_ai_02', [
            'uji' => $uji,
            'skema' => $uji->getSkema(false),
            'mahasiswa' => $uji->getMahasiswa(false),
            'daftarResponPerUnit' => $uji->getIsianFRAI02()['hasil']->groupBy('unit.id'),
            'isian' => $uji->getIsianFRAI02()['umum']
        ]);

        $pdf->setPaper('A4');

        return $pdf->stream();
    }

    public function cetakFRAI01(Uji $uji)
    {
        $pdf = PDF::loadView('form.fr_ai_01', [
            'uji' => $uji,
            'skema' => $uji->getSkema(false),
            'mahasiswa' => $uji->getMahasiswa(false)
        ]);

        // return view('form.fr_ai_01', [
        //     'uji' => $uji,
        //     'skema' => $uji->getSkema(false),
        //     'mahasiswa' => $uji->getMahasiswa(false)
        // ]);
    }

    public function cetakFRAC01(Uji $uji)
    {
        $asesi = $uji->getMahasiswa(false);
        $asesors = $uji->getAsesorUji(false);
        $skema = $uji->getSkema(false);

        $pdf = PDF::loadView('form.fr_ac_01', [
            'asesi' => $asesi,
            'asesors' => $asesors,
            'skema' => $skema,
            'uji' => $uji
        ]);
        $pdf->setPaper('A4');

        return $pdf->stream();
    }

    public function cetakFRAI04(Uji $uji)
    {
        $pdf = PDF::loadView('form.fr_ai_04', [
            'uji' => $uji,
            'form' => $uji->getFRAI04()
        ]);
        $pdf->setPaper('A4');

        return $pdf->stream();
//        return view('form.fr_ai_04', [
//            'uji' => $uji,
//            'form' => $uji->getFRAI04()
//        ]);
    }

    public function cetakFRAI05(Uji $uji, $c)
    {
        try {
            $c = decrypt($c);
            $c = (int)$c;
        } catch (DecryptException $exception){
            return 'Dekripsi gagal!';
        }

        $pdf = PDF::loadView('form.fr_ai_05', [
            'uji' => $uji,
            'data' => $uji->getFRAI05()[$c]
        ]);
        $pdf->setPaper('A4');

        return $pdf->stream();

//        return view('form.fr_ai_05', [
//            'uji' => $uji,
//            'data' => $uji->getFRAI05()[$c]
//        ]);
    }
}
