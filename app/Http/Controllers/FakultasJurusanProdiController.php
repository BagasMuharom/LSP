<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\Prodi;
use App\Support\ApiUnesa;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class FakultasJurusanProdiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:user', 'menu:fjp']);
    }

    public function sinkron()
    {
        $counterFakultasBaru = 0;
        $counterJurusanBaru = 0;
        $counterProdiBaru = 0;

        try{
            foreach (ApiUnesa::getFakultasJurusanProdi() as $keyfakultas => $fakultas) {
                if (empty($fakultas->nama)) {
                    if (Fakultas::check($keyfakultas, $fakultas)){
                        $f = Fakultas::findByKeyOrName($keyfakultas, $fakultas->nama);
                        $f->key = $keyfakultas;
                        $f->nama = $fakultas;
                        $f->save();
                    }
                    else{
                        $f = Fakultas::create([
                            'key' => $keyfakultas,
                            'nama' => $fakultas,
                        ]);
                        $counterFakultasBaru++;
                    }

                    if (Jurusan::check($keyfakultas, $fakultas)){
                        $j = Jurusan::findByKeyOrName($keyfakultas, $fakultas);
                        $j->key = $keyfakultas;
                        $j->nama = $fakultas;
                        $j->save();
                    }
                    else{
                        $j = Jurusan::create([
                            'fakultas_id' => $f->id,
                            'key' => $keyfakultas,
                            'nama' => $fakultas,
                        ]);
                        $counterJurusanBaru++;
                    }

                    if (Prodi::findByKeyOrName($keyfakultas, $fakultas)){
                        $p = Prodi::findByKeyOrName($keyfakultas, $fakultas);
                        $p->key = $keyfakultas;
                        $p->nama = $fakultas;
                        $p->save();
                    }
                    else{
                        Prodi::create([
                            'jurusan_id' => $j->id,
                            'key' => $keyfakultas,
                            'nama' => $fakultas,
                        ]);
                        $counterProdiBaru++;
                    }

                    continue;
                }

                if (Fakultas::check($keyfakultas, $fakultas->nama)){
                    $f = Fakultas::findByKeyOrName($keyfakultas, $fakultas->nama);
                    $f->key = $keyfakultas;
                    $f->nama = $fakultas->nama;
                    $f->save();
                }
                else{
                    $f = Fakultas::create([
                        'key' => $keyfakultas,
                        'nama' => $fakultas->nama,
                    ]);
                    $counterFakultasBaru++;
                }

                foreach ($fakultas->child as $keyjurusan => $jurusan) {
                    if (empty($jurusan->nama)) {
                        if (Jurusan::check($keyjurusan, $jurusan)){
                            $j = Jurusan::findByKeyOrName($keyjurusan, $jurusan);
                            $j->key = $keyjurusan;
                            $j->nama = $jurusan;
                            $j->save();
                        }
                        else{
                            $j = Jurusan::create([
                                'fakultas_id' => $f->id,
                                'key' => $keyjurusan,
                                'nama' => $jurusan,
                            ]);
                            $counterJurusanBaru++;
                        }

                        if (Prodi::findByKeyOrName($keyjurusan, $jurusan)){
                            $p = Prodi::findByKeyOrName($keyjurusan, $jurusan);
                            $p->key = $keyjurusan;
                            $p->nama = $jurusan;
                            $p->save();
                        }
                        else{
                            Prodi::create([
                                'jurusan_id' => $j->id,
                                'key' => $keyjurusan,
                                'nama' => $jurusan,
                            ]);
                            $counterProdiBaru++;
                        }

                        continue;
                    }

                    if (Jurusan::check($keyjurusan, $jurusan->nama)){
                        $j = Jurusan::findByKeyOrName($keyjurusan, $jurusan->nama);
                        $j->key = $keyjurusan;
                        $j->nama = $jurusan->nama;
                        $j->save();
                    }
                    else{
                        $j = Jurusan::create([
                            'key' => $keyjurusan,
                            'nama' => $jurusan->nama,
                            'fakultas_id' => $f->id,
                        ]);
                        $counterJurusanBaru++;
                    }

                    foreach ($jurusan->child as $keyprodi => $prodi) {
                        if (empty($prodi)) {
                            continue;
                        }

                        if (Prodi::findByKeyOrName($keyprodi, $prodi)){
                            $p = Prodi::findByKeyOrName($keyprodi, $prodi);
                            $p->key = $keyprodi;
                            $p->nama = $prodi;
                            $p->save();
                        }
                        else{
                            Prodi::create([
                                'key' => $keyprodi,
                                'nama' => $prodi,
                                'jurusan_id' => $j->id,
                            ]);
                            $counterProdiBaru++;
                        }
                    }
                }
            }

            return back()->with('success', 'Berhasil memperbarui data dan menambahkan <b>'.$counterFakultasBaru.' fakultas</b> baru, <b>'.$counterJurusanBaru.' jurusan</b> baru dan <b>'.$counterProdiBaru.' prodi</b> baru');
        }
        catch (QueryException $exception){
            return back()->with('error', $exception->getMessage());
        }
    }
}
