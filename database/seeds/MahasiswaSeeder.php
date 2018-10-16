<?php

use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use App\Support\ApiUnesa;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');

        foreach (ApiUnesa::getFakultasJurusanProdi() as $keyfakuktas => $fakultas) {
            if (empty($fakultas->nama)) {
                continue;
            }

            if (strtolower($fakultas->nama) != 'teknik') {
                continue;
            }

            foreach ($fakultas->child as $keyjurusan => $jurusan) {
                if (empty($jurusan->nama)) {
                    continue;
                }

                foreach ($jurusan->child as $keyprodi => $prodi) {
                    if (empty($prodi)) {
                        continue;
                    }

                    $prodi = Prodi::where('nama', $prodi)->first();

                    $daftar = ApiUnesa::getMahasiswaPerProdi($keyprodi);
                    $keyrandom = $daftar->keys();

                    try {
                        if ($prodi->nama != 'S1 Teknik Informatika')
                            $keyrandom = $daftar->keys()->random(5);
                    }
                    catch (InvalidArgumentException $err) {}

                    foreach ($keyrandom as $nim) {
                        if (($prodi->nama == 'S1 Teknik Informatika' && strpos($nim, '150') === 0) || $prodi->nama != 'S1 Teknik Informatika')
                            $this->create($nim, $prodi, $faker);
                    }

                }
            }
        }
    }

    private function create($nim, $prodi, $faker)
    {
        $mhs = ApiUnesa::getDetailMahasiswa($nim);

        if (empty($mhs->nama_mahasiswa))
            return;

        Mahasiswa::create([
            'nim' => $nim,
            'nik' => $faker->unique()->numerify('################'),
            'nama' => $mhs->nama_mahasiswa,
            'email' => empty($mhs->email) ? $faker->unique()->email : $mhs->email,
            'password' => bcrypt('secret'),
            'terverifikasi' => true,
            'prodi_id' => $prodi->id,
            'alamat' => empty($mhs->jln) ? $faker->address : $mhs->jln,
            'no_telepon' => $faker->phoneNumber,
            'tempat_lahir' => empty($mhs->tempat_lahir) ? $faker->city : $mhs->tempat_lahir,
            'tgl_lahir' => Carbon::parse($mhs->tgl_lahir),
            'kabupaten' => $mhs->nama_wilayah->nm_kab,
            'provinsi' => $mhs->nama_wilayah->nm_prop,
            'jenis_kelamin' => $mhs->jenis_kelamin,
            'pendidikan' => 'SMA atau sederajat',
            'pekerjaan' => 'Mahasiswa/pelajar'
        ]);
    }

}
