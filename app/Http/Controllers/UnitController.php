<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\UnitKompetensi;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\ElemenKompetensi;
use Illuminate\Support\Facades\DB;
use Prophecy\Exception\Doubler\MethodNotFoundException;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:user', 'menu:unit']);
    }

    public function updateKriteria(Request $request)
    {
        try{
            DB::transaction(function () use ($request){
                $elemen = ElemenKompetensi::findOrFail(decrypt($request->elemen_id));

                $elemen->getKriteria()->whereNotIn('id', (empty($request->kriteria_id) ? [] : $request->kriteria_id))->delete();

                if (!empty($request->kriteria_id)){
                    $counter = 0;
                    foreach ($request->kriteria_id as $id){
                        $kriteria = Kriteria::findOrFail($id);
                        $kriteria->pertanyaan = $request->pertanyaan[$counter];
                        $kriteria->unjuk_kerja = $request->unjuk_kerja[$counter];
                        $kriteria->save();
                        $counter++;
                    }
                }

                if (!empty($request->unjuk_kerja_baru)){
                    $counter = 0;
                    foreach ($request->unjuk_kerja_baru as $unjuk_kerja){
                        Kriteria::create([
                            'elemen_kompetensi_id' => $elemen->id,
                            'unjuk_kerja' => $unjuk_kerja,
                            'pertanyaan' => $request->pertanyaan_baru[$counter++]
                        ]);
                    }
                }
            }, 5);

            return back()->with('success', 'Berhasil memperbarui kriteria');
        }
        catch (ModelNotFoundException $exception){
            return back()->with('error', 'Data tidak ditemukan');
        }
    }

    /**
     * Mengubah elemen pada unit tertentu
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateElemen(Request $request)
    {
        try{
            $elemen = ElemenKompetensi::findOrFail(decrypt($request->id));
            $nama = $elemen->nama;
            $elemen->nama = $request->nama;
            $elemen->benchmark = $request->benchmark;
            $elemen->save();
            return back()->with('success', 'Berhasil memperbarui elemen <b>'.$nama.'</b>'.' menjadi <b>'.$elemen->nama.'</b>');
        }
        catch (ModelNotFoundException $exception){
            return back()->with('error', 'Data tidak ditemukan');
        }
    }

    public function deleteElemen(Request $request)
    {
        try{
            $elemen = ElemenKompetensi::findOrFail(decrypt($request->id));
            $elemen->delete();
            return back()->with('success', 'Berhasil menghapus <b>'.$elemen->nama.'</b>');
        }
        catch (MethodNotFoundException $exception){
            return back()->with('error', 'Data tidak ditemukan');
        }
    }

    /**
     * Menambahkah elemen baru pada unit tertentu
     * elemen yang ditambahkan bisa lebih dari satu dengan pemisah enter
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function addElemen(Request $request)
    {
        $this->validate($request, [
            'unit_id' => 'required',
            'namas' => 'required'
        ]);

        $counter = 0;
        foreach (explode(PHP_EOL, $request->namas) as $nama) {
            ElemenKompetensi::create([
                'unit_kompetensi_id' => $request->unit_id,
                'nama' => $nama,
                'benchmark' => 'SKKNI'
            ]);
            $counter++;
        }

        return back()->with('success', 'Berhasil menambahkan ' . $counter . ' elemen');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'nama' => 'required',
            'kode' => 'required'
        ]);
        try{
            $unit = UnitKompetensi::findOrFail(decrypt($request->id));
            $unit->kode = $request->kode;
            $unit->nama = $request->nama;
            $unit->save();
            return back()->with('success', 'Berhasil memperbarui data');
        }
        catch (MethodNotFoundException $exception){
            return back()->with('error', 'Data tidak ditemukan');
        }
        catch (QueryException $exception){
            return back()->with('error', 'Mungkin telah ada kode atau nama yang sama<br>'.$exception->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try{
            $unit = UnitKompetensi::findOrFail(decrypt($request->id));
            $unit->delete();
            return back()->with('success', 'Berhasil menghapus <b>'.$unit->kode.', '.$unit->nama.'</b>');
        }
        catch (ModelNotFoundException $exception){
            return back()->with('error', 'Data tidak ditemukan');
        }
    }

    public function restore(Request $request)
    {
        try{
            $unit = UnitKompetensi::onlyTrashed()->where('id', decrypt($request->id));
            $unit->restore();
            return back()->with('success', 'Berhasil mengembalikan data');
        }
        catch (ModelNotFoundException $exception){
            return back()->with('error', 'Data tidak ditemukan');
        }
        catch (QueryException $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Menambahkan pertanyaan observasi pada unit tertentu
     * pertanyaan yang dimasukkan bisa lebih dari dari dengan dipisah enter
     *
     * @param Request $request
     * @param UnitKompetensi $unit
     * @return \Illuminate\Http\Response
     */
    public function tambahPertanyaanObservasi(Request $request, UnitKompetensi $unit)
    {
        $request->validate([
            'daftar_pertanyaan' => 'required|string'
        ]);
        
        foreach (explode(PHP_EOL , $request->daftar_pertanyaan) as $pertanyaan) {
            $unit->getPertanyaanObservasi()->insert([
                'pertanyaan' => $pertanyaan,
                'unit_kompetensi_id' => $unit->id
            ]);
        }

        return back()->with([
            'success' => 'Berhasil menambahkan pertanyaan observasi untuk unit ' . $unit->judul . ' !'
        ]);
    }

}
