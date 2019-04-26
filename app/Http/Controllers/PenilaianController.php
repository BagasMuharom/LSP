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
            $uji->ttd_peserta = $request->ttd_asesi;
            $uji->rekomendasi_asesor = $request->rekomendasi_asesor;
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

            foreach ($request->ttd_asesor as $id => $value) {
                $uji->getAsesorUji()->updateExistingPivot($id, [
                    'ttd' => $value,
                ]);
            }
        }, 5);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menyimpan penilaian',
        ]);
    }

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
            } else {
                $uji->umpan_balik = 'Terdapat Elemen Kompetensi/Kriteria Unjuk Kerja (KUK) yang diujikan belum tercapai';

                $uji->identifikasi_kesenjangan = "Ditemukan kesenjangan pencapaian, sebagai berikut pada :<br/>";

                foreach ($uji->getUnitYangBelumKompeten(false) as $unit) {
                    $uji->identifikasi_kesenjangan = $uji->identifikasi_kesenjangan . "{$unit->kode} ({$unit->nama})<br/>";

                    foreach ($uji->getElemenYangBelumKompeten($unit, false) as $elemen) {
                        foreach ($uji->getKriteriaYangBelumKompeten($elemen, false) as $kriteria) {
                            $uji->identifikasi_kesenjangan = $uji->identifikasi_kesenjangan . "> {$elemen->nama} \ {$kriteria->unjuk_kerja}<br/>";
                        }
                    }
                }

                $uji->saran_tindak_lanjut = "Perlu dilakukan asesmen ulang pada :\nKode dan Judul Unit Kompetensi :\n";
                $counter = 1;
                foreach ($uji->getUnitYangBelumKompeten(false) as $unit) {
                    $uji->saran_tindak_lanjut = $uji->saran_tindak_lanjut . "{$counter}. {$unit->kode} ({$unit->nama})\n";
                    $counter++;
                }

                $uji->lulus = false;
            }
            
            $uji->save();

            return back()->with('success', 'Berhasil mengkonfirmasi penilaian');
        }

        return back()->with('error', 'Penilaian belum selesai');
    }
}