<?php

use Illuminate\Database\Seeder;
use App\Models\Sertifikat;
use App\Models\Kuesioner;
use Faker\Factory;
use Carbon\Carbon;

class KuesionerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kuesioner::query()->delete();

        $faker = Factory::create('id_ID');
        foreach (Sertifikat::all() as $sertifikat){
            Kuesioner::create([
                'sertifikat_id' => $sertifikat->id,
                'kegiatan_setelah_mendapatkan_sertifikasi' => ($kerja = rand(0, 1)) ? 'Bekerja di '.($perusahaan = $faker->company).' sebagai '.$faker->jobTitle : $faker->sentence(rand(3, 5)),
                'nama_perusahaan' => $kerja ? $perusahaan : null,
                'alamat_perusahaan' => $kerja ? $faker->address : null,
                'jenis_perusahaan' => $kerja ? ['Barang', 'Jasa', 'Barang dan Jasa'][rand(0, 2)] : null,
                'tahun_memulai_kerja' => $kerja ? rand(2017, Carbon::now()->year) : null,
                'relevansi_sertifikasi_kompetensi_bidang_dengan_pekerjaan' => $kerja ? $faker->sentence(rand(2,5)) : null,
                'manfaat_sertifikasi_kompetensi' => '{"mempermudah_mencari_pekerjaan":"'.$this->randYaTidak().'","membedakan_jenis_pekerjaan":"'.$this->randYaTidak().'","menaikkan_gaji":"'.$this->randYaTidak().'"}',
                'saran_perbaikan_untuk_lsp_unesa' => $faker->text
            ]);
        }
    }

    private function randYaTidak(){
        return (rand(0,1) ? 'Ya' : 'Tidak');
    }
}
