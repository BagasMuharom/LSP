<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Syarat;
use App\Models\TempatUji;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Skema;
use App\Models\Menu;
use App\Models\UnitKompetensi;
use Illuminate\Support\Facades\DB;
use Prophecy\Exception\Doubler\MethodNotFoundException;

class SkemaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user')->except(['getDaftarSyarat']);
        $this->middleware('menu:skema')->except([
            'getDaftarSyarat', 'getDaftarSkema'
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'jenis_id' => 'required',
            'jurusan_id' => 'required',
            'kode' => 'required',
            'nama' => 'required',
            'nama_english' => 'required',
            'sektor' => 'required',
            'kbli' => 'required',
            'kbji' => 'required',
            'level_kkni' => 'required',
            'kode_unit_skkni' => 'required',
            'kualifikasi' => 'required',
            'qualification' => 'required',
            'field' => 'required',
            'bidang' => 'required'
        ]);

        try {
            $tipe = 'success';
            $pesan = 'Berhasil memperbarui data';

            $skema = Skema::findOrFail(decrypt($request->id));
            if ($skema->kode != $request->kode) {
                if (Skema::isAvailable($request->kode)) {
                    return back()->with('error', 'Skema dengan kode ' . $request->kode . ' telah tersedia');
                }
            }

            $skema->update([
                'jenis_id' => $request->jenis_id,
                'jurusan_id' => $request->jurusan_id,
                'kode' => $request->kode,
                'nama' => $request->nama,
                'nama_english' => $request->nama_english,
                'sektor' => $request->sektor,
                'keterangan' => $request->keterangan or '',
                'kbli' => $request->kbli,
                'kbji' => $request->kbji,
                'level_kkni' => $request->level_kkni,
                'kode_unit_skkni' => $request->kode_unit_skkni,
                'kualifikasi' => $request->kualifikasi,
                'qualification' => $request->qualification,
                'field' => $request->field,
                'bidang' => $request->bidang
            ]);

            try{
                $tu = TempatUji::query()->findOrFail($request->tempat_uji_id);
                $tu->kode = $request->tempat_uji_kode;
                $tu->nama = $request->tempat_uji_nama;
                $tu->save();
            } catch (ModelNotFoundException $exception){
                $tu = TempatUji::create([
                    'kode' => strtoupper($request->tempat_uji_kode),
                    'nama' => $request->tempat_uji_nama,
                    'jurusan_id' => $request->tempat_uji_jurusan_id
                ]);
            }
            $skema->tempat_uji_id = $tu->id;
            $skema->save();

            $skema->getSkemaUnit()->detach();
            if (!is_null($request->kodeunit) && !is_null($request->namaunit)) {
                $counter = 0;
                foreach ($request->kodeunit as $kode) {
                    if (UnitKompetensi::isAvailable($kode)) {
                        $unit = UnitKompetensi::where('kode', $kode)->first();
                    } elseif (UnitKompetensi::isAvailableInTrash($kode)) {
                        UnitKompetensi::withTrashed()->where('kode', $kode)->restore();
                        $unit = UnitKompetensi::where('kode', $kode)->first();
                        $tipe = 'warning';
                        $pesan = $pesan . "<br>Unit dengan kode <b>{$kode}</b> pernah dihapus, sehingga data dikembalikan lagi.";
                    } else {
                        $unit = UnitKompetensi::create([
                            'kode' => $kode,
                            'nama' => $request->namaunit[$counter]
                        ]);
                    }
                    $skema->getSkemaUnit()->attach($unit);
                    $counter++;
                }
            }

            return back()->with($tipe, $pesan);
        } catch (ModelNotFoundException $exception) {
            return back()->with('error', 'Data tidak ditemukan!');
        }
    }

    /**
     * Mendapatkan daftar perysratan untuk mengajukan sertifikasi
     * dengan skema tertentu
     *
     * @param Request $request
     * @return \ILluminate\Http\Response
     */
    public function getDaftarSyarat(Request $request)
    {
        try {
            $skema = Skema::find($request->skema);
            return response()->json($skema->getSyarat()->where('upload', true)->get());
        } catch (ModelNotFoundException $err) {
            return abort(404);
        }
    }

    /**
     * Mendapatkan daftar skema sesuai keyword
     *
     * @param Request $request
     * @return void
     */
    public function getDaftarSkema(Request $request)
    {
        return response()->json(
            Skema::where('nama', 'ILIKE', '%' . ($request->has('q') ? $request->q : $request->keyword) . '%')->get()
        );
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'jenis_id' => 'required',
            'jurusan_id' => 'required',
            'kode' => 'required',
            'nama' => 'required',
            'nama_english' => 'required',
            'sektor' => 'required',
            'kbli' => 'required',
            'kbji' => 'required',
            'level_kkni' => 'required',
            'kode_unit_skkni' => 'required',
            'kualifikasi' => 'required',
            'qualification' => 'required',
            'field' => 'required',
            'bidang' => 'required'
        ]);

        if (Skema::isAvailable($request->kode)) {
            return back()->with('error', 'Skema dengan kode ' . $request->kode . ' telah tersedia');
        }

        DB::transaction(function () use ($request) {
            $skema = Skema::create([
                'jenis_id' => $request->jenis_id,
                'jurusan_id' => $request->jurusan_id,
                'kode' => $request->kode,
                'nama' => $request->nama,
                'nama_english' => $request->nama_english,
                'sektor' => $request->sektor,
                'keterangan' => $request->keterangan or '',
                'kbli' => $request->kbli,
                'kbji' => $request->kbji,
                'level_kkni' => $request->level_kkni,
                'kode_unit_skkni' => $request->kode_unit_skkni,
                'kualifikasi' => $request->kualifikasi,
                'qualification' => $request->qualification,
                'field' => $request->field,
                'bidang' => $request->bidang
            ]);

            if (TempatUji::check($request->tempat_uji_kode)) {
                $skema->tempat_uji_id = TempatUji::findByKode($request->tempat_uji_kode)->id;
            } else {
                $tu = TempatUji::create([
                    'kode' => strtoupper($request->tempat_uji_kode),
                    'nama' => $request->tempat_uji_nama,
                    'jurusan_id' => $request->tempat_uji_jurusan_id
                ]);
                $skema->tempat_uji_id = $tu->id;
            }
            $skema->save();

            if (!is_null($request->kodeunit) && !is_null($request->namaunit)) {
                $counter = 0;
                foreach ($request->kodeunit as $kode) {
                    if (UnitKompetensi::isAvailable($kode)) {
                        $unit = UnitKompetensi::where('kode', $kode)->first();
                    } else {
                        $unit = UnitKompetensi::create([
                            'kode' => $kode,
                            'nama' => $request->namaunit[$counter]
                        ]);
                    }
                    $skema->getSkemaUnit()->attach($unit);
                    $counter++;
                }
            }
        }, 5);

        return redirect()->route('skema')->with('success', 'Berhasil menambahkan skema dengan kode <b>' . $request->kode . '</b>');
    }

    public function delete(Request $request)
    {
        try {
            $skema = Skema::findOrFail(decrypt($request->id));
            $skema->delete();
            return back()->with('success', 'Berhasil menghapus skema dengan kode <b>' . $skema->kode . '</b> yang berjudul <b>' . $skema->nama . '</b>');
        } catch (ModelNotFoundException $exception) {
            return back()->with('error', 'Data tidak ditemukan!');
        }
    }

    public function updateJenis(Request $request)
    {
        try {
            $jenis = Jenis::findOrFail(decrypt($request->id));
            $jenis->nama = $request->nama;
            $jenis->save();
            return back()->with('success', 'Berhasil memperbarui data');
        } catch (ModelNotFoundException $exception) {
            return back()->with('error', 'Data tidak ditemukan!');
        } catch (QueryException $exception) {
            return back()->with('error', 'Jenis tersebut telah tersedia<br>' . $exception->getMessage());
        }
    }

    public function addJenis(Request $request)
    {
        $counter = 0;
        foreach (explode(PHP_EOL, $request->nama) as $nama) {
            try {
                Jenis::create(['nama' => $nama]);
                $counter++;
            } catch (QueryException $exception) {

            }
        }
        return back()->with('success', 'Berhasil menambahkan ' . $counter . ' jenis skema');
    }

    public function deleteJenis(Request $request)
    {
        try {
            $jenis = Jenis::findOrFail(decrypt($request->id));
            $jenis->delete();
            return back()->with('success', 'Berhasil menghapus <b>' . $jenis->nama . '</b>');
        } catch (ModelNotFoundException $exception) {
            return back()->with('error', 'Data tidak ditemukan!');
        }
    }

    public function restore(Request $request)
    {
        $skema = Skema::onlyTrashed()
            ->where('id', decrypt($request->id))
            ->first();
        $skema->restore();

        return back()->with('success', 'Berhasil mengembalikan <b>' . $skema->kode . '</b>');
    }

    public function updateSyarat(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        try {
            $skema = Skema::findOrFail(decrypt($request->id));
            try {
                $skema->getSyarat()->whereNotIn('id', array_keys($request->syarat))->delete();
            } catch (\ErrorException $exception) {
                $skema->getSyarat()->delete();
            }

            try {
                foreach ($request->syarat as $id => $nama) {
                    Syarat::findOrFail($id)->update([
                        'nama' => $nama,
                        'upload' => ($request->has('upload.' . $id) && $request->input('upload.' . $id) == 'on')
                    ]);
                }
            } catch (\ErrorException $exception) {

            }

            try {
                foreach ($request->namabaru as $index => $nama) {
                    Syarat::create([
                        'nama' => $nama,
                        'skema_id' => $skema->id,
                        'upload' => ($request->has('uploadbaru.' . $index) && $request->input('uploadbaru.' . $index) == 'on')
                    ]);
                }
            } catch (\ErrorException $exception) {

            }

            return back()->with('success', 'Berhasil memperbarui persyaratan');
        } catch (ModelNotFoundException $exception) {
            return back()->with('error', 'Data tidak ditemukan!');
        }
    }
}
