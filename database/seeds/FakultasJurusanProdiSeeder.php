<?php

use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\Prodi;
use App\Support\ApiUnesa;
use Illuminate\Database\Seeder;

class FakultasJurusanProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (ApiUnesa::getFakultasJurusanProdi() as $keyfakultas => $fakultas) {
            if (empty($fakultas->nama)) {
                continue;
            }

            $f = Fakultas::create([
                'key' => $keyfakultas,
                'nama' => $fakultas->nama,
            ]);

            foreach ($fakultas->child as $keyjurusan => $jurusan) {
                if (empty($jurusan->nama)) {
                    continue;
                }

                $j = Jurusan::create([
                    'key' => $keyjurusan,
                    'nama' => $jurusan->nama,
                    'fakultas_id' => $f->id,
                ]);

                foreach ($jurusan->child as $keyprodi => $prodi) {
                    if (empty($prodi)) {
                        continue;
                    }

                    $p = Prodi::create([
                        'key' => $keyprodi,
                        'nama' => $prodi,
                        'jurusan_id' => $j->id,
                    ]);

                }
            }
        }
    }

}
