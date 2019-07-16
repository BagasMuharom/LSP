<?php

namespace App\Http\Controllers;

use App\Models\Uji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    /**
     * Melakukan proses penilaian
     *
     * @param Request $request
     * @param Uji $uji
     * @return \Illuminate\Http\Response
     */
    public function nilai(Request $request, Uji $uji)
    {
        $nilai = collect(json_decode($request->nilai))->filter(function ($value, $key) {
            return ($value->nilai != null || $value->bukti != null);
        })->all();

        DB::transaction(function () use ($request, $uji, $nilai) {
            $helper = $uji->helper;
            $helper['nilai_unit'] = json_decode($request->nilai_unit, true);
            $uji->helper = $helper;
            $uji->save();

            foreach ($nilai as $id => $value) {
                $uji->getPenilaian()->updateExistingPivot($id, [
                    'nilai' => $value->nilai,
                    'bukti' => $value->bukti,
                ]);
            }

        }, 5);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menyimpan penilaian',
        ]);
    }

    /**
     * Melakukan konfirmasi penilaian terhadap uji tertentu
     *
     * @param \App\Models\Uji $uji
     * @return \Illuminate\Http\Response
     */
    public function konfirmasi(Uji $uji)
    {
        if ($uji->isFinished()) {
            $uji->konfirmasi_penilaian_asesor = true;
            $uji->save();

            if ($uji->isLulus()) {
                $uji->umpan_balik = 'Seluruh Elemen Kompetensi/Kriteria Unjuk Kerja (KUK) yang diujikan telah tercapai';
                $uji->identifikasi_kesenjangan = 'Tidak ada kesenjangan';
                $uji->saran_tindak_lanjut = 'Agar memelihara kompetensi yang telah dicapai';
                $uji->lulus = true;
                $uji->rekomendasi_asesor = "Asesi direkomendasikan <b>Kompeten</b> pada <b>skema {$uji->getSkema(false)->nama}</b>";
            } else {
                $uji->umpan_balik = 'Terdapat Elemen Kompetensi/Kriteria Unjuk Kerja (KUK) yang diujikan belum tercapai';

                $uji->identifikasi_kesenjangan = "Ditemukan kesenjangan pencapaian, sebagai berikut pada :<br/>";

                $uji->rekomendasi_asesor = "Asesi direkomendasikan <b>Belum Kompeten</b> pada <b>skema {$uji->getSkema(false)->getJenis(false)->nama}</b><br>Asesmen yang diajukan (<b>{$uji->getSkema(false)->nama}</b>)";

                foreach ($uji->getUnitYangBelumKompeten(false) as $unit) {
                    $uji->identifikasi_kesenjangan = $uji->identifikasi_kesenjangan . "{$unit->kode} ({$unit->nama})<br/>";

                    foreach ($uji->getElemenYangBelumKompeten($unit, false) as $elemen) {
                        foreach ($uji->getKriteriaYangBelumKompeten($elemen, false) as $kriteria) {
                            $uji->identifikasi_kesenjangan = $uji->identifikasi_kesenjangan . "> {$elemen->nama} : {$kriteria->unjuk_kerja}<br/>";
                        }
                    }
                }

                $uji->saran_tindak_lanjut = "Perlu dilakukan asesmen ulang pada :<br/>Kode dan Judul Unit Kompetensi :<br/>";
                $counter = 1;
                foreach ($uji->getUnitYangBelumKompeten(false) as $unit) {
                    $uji->saran_tindak_lanjut = $uji->saran_tindak_lanjut . "{$counter}. {$unit->kode} ({$unit->nama})<br/";
                    $counter++;
                }

                $uji->lulus = false;
            }
            
            $uji->save();

            return back()->with('success', 'Berhasil mengkonfirmasi penilaian');
        }

        return back()->with('error', 'Penilaian belum selesai');
    }

    /**
     * Membatalkan konfirmasi penilaian pada uji tertentu
     *
     * @param \App\Models\Uji $uji
     * @return \Illuminate\Http\Response
     */
    public function batalkanKonfirmasi(Uji $uji)
    {
        $uji->update([
            'konfirmasi_penilaian_asesor' => false
        ]);

        return back()->with('success', 'Berhasil membatalkan konfirmasi !');
    }

}
