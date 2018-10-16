<?php

use Illuminate\Database\Seeder;
use App\Support\Penilaian;
use App\Models\Uji;
use App\Models\Mahasiswa;
use App\Models\Sertifikat;
use App\Models\Skema;
use App\Models\Event;
use Faker\Factory;
use App\Models\TempatUji;
use App\Models\Role;
use Carbon\carbon;

class UjiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');
        // membuat uji per mahasiswa
        foreach (Mahasiswa::all() as $index => $mahasiswa){
            $events = Event::whereHas('getDana', function ($query) {
                $query->where('nama', '!=', 'Mandiri');
            })->get()->random(rand(1, 4));

            // satu mahasiswa daftar bisa lebih dari 1 skema
            foreach ($events as $event){

                $skema = $event->getSkema(false);

                // membuat uji
                $uji = Uji::create([
                    'nim' => $mahasiswa->nim,
                    'event_id' => $event->id,
                    'created_at' => $waktu_daftar = $faker->dateTimeThisYear,
                    'updated_at' => $waktu_daftar
                ]);

                // memenuhi syarat
                foreach ($skema->getSyarat(false) as $syarat){
                    $uji->getSyaratUji()->attach($syarat, [
                        'filename' => 'syarat.jpg'
                    ]);
                }

                // sertifikasi admin
                if (rand(0, 10) < 8) {
                    $uji->update([
                        'terverifikasi_admin' => true,
                        'admin_id' => Role::where('nama', Role::ADMIN)->first()->getUserRole(false)->random()->id
                    ]);

                    // sertifikasi bag. sertifikasi
                    if (rand(0, 10) < 8) {
                        $uji->update([
                            'terverifikasi_bag_sertifikasi' => true,
                            'bag_sertifikasi_id' => Role::where('nama', Role::SERTIFIKASI)->first()->getUserRole(false)->random()->id
                        ]);

                        if (rand(0, 1) < 8) {
                            // membuat penilaian diri
                            if (rand(0, 1) == 1) {
                                foreach ($skema->getKriteria(false) as $kriteria){
                                    $uji->getPenilaianDiri()->updateExistingPivot($kriteria, [
                                        'nilai' => rand(0, 1) == 1 ? Penilaian::KOMPETEN : Penilaian::BELUM_KOMPETEN
                                    ]);
                                }
                            }
                            else {
                                foreach ($skema->getKriteria(false) as $kriteria){
                                    $uji->getPenilaianDiri()->updateExistingPivot($kriteria, [
                                        'nilai' => Penilaian::KOMPETEN
                                    ]);
                                }
                            }

                            // melakukan penilaian ?
                            if (rand(0, 10) < 8) {
                                // generate asesor
                                $temp = $uji->getSkema(false)->getAsesorSkema(false)->random(2);
                                for ($i = 0; $i < rand(1, 2);$i++) {
                                    $uji->getAsesorUji()->attach($temp[$i]->id);
                                }
                                $uji->getAsesorUji()->attach(1);
                                $uji->update([
                                    'rekomendasi_asesor_asesmen_diri' => $faker->sentence,
                                    'catatan_asesmen_diri' => $faker->sentence,
                                    'tanggal_uji' => $uji->getEvent(false)->tanggal_uji
                                ]);
                                    
                                // asesor mengisi asesmen diri
                                if (rand(0, 10) < 8) {
                                    // jika lulus
                                    $uji->getPenilaianDiri()->newPivotStatement()
                                        ->update([
                                            'v' => true
                                        ]);
                                }
                                    
                                $uji->konfirmasi_asesmen_diri = true;
                                $uji->initPenilaian();

                                // menentukan apakah mahasiswa ini lulus atau tidak

                                if ($uji->isLulusPenilaianDiri()) {
                                    if (rand(0,1) === 1) {
                                        // membuat penilaian
                                        foreach ($skema->getKriteria(false) as $kriteria){
                                            $uji->getPenilaian()->updateExistingPivot($kriteria, [
                                                'nilai' => Penilaian::KOMPETEN,
                                                'bukti' => Penilaian::BUKTI_LANGSUNG
                                            ]);
                                        }

                                        $uji->update([
                                            'konfirmasi_penilaian_asesor' => true
                                        ]);

                                        if (rand(0,1) === 1) {
                                            $date = $faker->dateTimeThisYear->format('Y-m-d');
                                            Sertifikat::create([
                                                'uji_id' => $uji->id,
                                                'issue_date' => $date,
                                                'expire_date' => Carbon::parse($date)->addYears(3),
                                                'no_urut_cetak' => $faker->numerify('000000##'),
                                                'no_urut_skema' => $faker->numerify('0000#'),
                                                'tanggal_cetak' => $date,
                                                'tahun' => 2018
                                            ]);
                                        }

                                    }
                                    else{
                                        // membuat penilaian
                                        foreach ($skema->getKriteria(false) as $kriteria){
                                            $uji->getPenilaian()->attach($kriteria, [
                                                'nilai' => Penilaian::ARRAY[rand(0,2)],
                                                'bukti' => Penilaian::BUKTI_LANGSUNG
                                            ]);
                                        }

                                    }
                                }
                                
                            }
                        }
                    }
                    else {
                        if (rand(0, 1) === 0) {
                            $uji->update([
                                'terverifikasi_bag_sertifikasi' => false,
                                'bag_sertifikasi_id' => Role::where('nama', Role::SERTIFIKASI)->first()->getUserRole(false)->random()->id,
                                'catatan' => $faker->text(50)
                            ]);
                        }
                    }
                }
                else{
                    if (rand(0, 1) === 0) {
                        $uji->update([
                            'terverifikasi_admin' => false,
                            'admin_id' => Role::where('nama', Role::ADMIN)->first()->getUserRole(false)->random()->id,
                            'catatan' => $faker->text(50)
                        ]);
                    }
                }

            }
        }
    }
}
