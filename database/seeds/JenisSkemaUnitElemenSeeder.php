<?php

use Illuminate\Database\Seeder;
use App\Models\Skema;
use App\Models\Jenis;
use App\Models\UnitKompetensi;
use App\Models\ElemenKompetensi;
use Faker\Factory;
use App\Models\Kriteria;
use App\Models\Fakultas;
use App\Models\TempatUji;

class JenisSkemaUnitElemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');
        $data = "Junior Web Programmer;017/JWP/UN38.5.5/2017;OKUPASI;Teknologi Informasi Dan Komunikasi Bidang Keahlian Programmer Komputer;J.620100.016.01|Menulis Kode dengan Prinsip Sesuai Guidelines dan Best Practices&J.620100.017.02|Mengimplementasikan Pemrograman Terstruktur&J.620100.019.02|Menggunakan Library atau Komponen Pre-Existing&J.620100.023.02|Membuat Dokumen Kode Program&J.620100.004.02|Menggunakan Struktur Data&J.620100.025.02|Melakukan Debugging&J.620100.011.01|Melakukan Instalasi Software Tools Pemrograman&J.620100.005.02|Mengimplementasikan User Interface^Teknisi Akuntansi Ahli;021/TAA/UN38.7.2/2017;OKUPASI;Jasa Akuntansi, Pembukuan dan Pemeriksa, Konsultasi Pajak / Jasa Akuntansi;M.692000.003.02|Melaksanakan Prinsip-prinsip Supervisi&M.692000.004.02|Melakukan Komunikasi Bisnis yang Efektif &M.692000.014.02|Menyajikan Laporan Keuangan Konsolidasi&M.692000.015.02|Menyajikan Informasi Kinerja Keuangan dan Bisnis&M.692000.017.02|Menyajikan Informasi Akuntansi Manajemen&M.692000.018.02|Menyiapkan Anggaran Perusahaan&M.692000.021.02|Memelihara Sistem Informasi Akuntansi^Teknisi Akuntansi Madya;020/TAM/UN38.7.2/2017;OKUPASI;Jasa Akuntansi, Pembukuan dan Pemeriksa, Konsultasi Pajak / Jasa Akuntansi;M.692000.001.02|Menerapkan Prinsip Praktik Profesional dalam Bekerja&M.692000.002.02|Menerapkan Praktik-Praktik Kesehatan dan Keselamatan di Tempat Kerja &M.692000.012.02|Mengelola Kartu Aktiva Tetap&M.692000.016.02|Menyajikan Laporan Harga Pokok Produk&M.692000.019.02|Menyiapkan Surat Pemberitahuan Pajak&M.692000.020.02|Mengimplementasikan Suatu Sistem Komputer Akuntansi&M.692000.025.02|Mengembangkan Database^Digital Imaging;019/DIM/UN38.5.5/2017;OKUPASI;Teknologi Informasi dan Komunikasi Bidang Keahlian Multimedia;M.74100.002.02|Menerapkan Prinsip Dasar Komunikasi&TIK.OP02.015.01|Mempergunakan Perangkat Keras dan Piranti Lunak Untuk Memindai Dokumen dan Gambar&J.LSPK.MM03.01|Mentrasfer File Multimedia ke Dalam Sistem Komputer (SK)&M.74100.010.01|Menciptakan Karya Desain&TIK.OP02.019.01|Mengoperasikan Piranti Lunak Pengolah Gambar Vektor&TIK.MM01.008.01|Menerapkan Prinsip – prinsip Rancangan Visual&TIK.MM02.010.01|Men-set-up Sebuah Kamera&TIK.MM02.0053.01|Membuat dan Memamipulasi Gambar-gambar Digital&TIK.OP02.002.01|Mengoperasikan Printer^Teknisi Muda Jaringan Komputer;018/TMJ/UN38.5.5/2017;OKUPASI;Informasi dan Komunikasi Golongan Pokok Telekomunikasi Bidang Jaringan Komputer;J.611000.001.01|Mengumpulkan Kebutuhan Teknis Pengguna yang Menggunakan Jaringan&J.611000.002.01|Mengumpulkan Data Peralatan Jaringan dengan Teknologi yang Sesuai&J.611000.003.02|Merancang Topologi Jaringan&J.611000.004.01|Merancang Pengalamatan Jaringan&J.611000.005.02|Menentukan Spesifikasi Perangkat Jaringan&J.611000.009.02|Memasang Kabel Jaringan&J.611000.012.02|Mengkonfigurasi Switch pada Jaringan^Pemrogram Mobil Pratama (Junior Mobile Programmer);016/JMP/UN38.5.5/2017;OKUPASI;Jasa Informasi / Mobile Computing;J.612000.001|Menunjukkan Platform Operating System dan Bahasa Pemrograman di dalam Perangkat Lunak&J.612000.003|Merancang Database dan Data Persistence pada Mobile Data&J.612000.007|Merancang Mobile Interface&J.612000.025|Menentukan Mobile Seluler Network&J.612000.022|Menjelaskan Mobile Sensor dan Spesifikasi Teknisnya untuk Mobile Computing&J.612000.006|Menyusun Mobile Location Based Service, GPS, dan Mobile Navigation&J.612000.008|Menjelaskan Dasar-dasar Mobile Security^Advance Office Operator;015/AOO/UN38.5.5/2017;OKUPASI;Teknologi Informasi dan Komunikasi Bidang Operator Komputer;TIK.OP02.012.01|Mengoperasikan piranti lunak pengolah kata - Tingkat Maju&TIK.OP03.002.01|Mengoperasikan dasar-dasar basis data (database)&TIK.OP02.007.01|Mengoperasikan piranti lunak klien e-mail (e-mail client)&TIK.OP02.013.01|Mengoperasikan piranti lunak lembar sebar - Tingkat Maju&TIK.OP02.011.01|Mengoperasikan piranti lunak presentasi&TIK.OP02.016.01|Melakukan konversi data dari berbagai aplikasi perkantoran^Kepala Dapur;014/KPD/UN38.5.4/2017;OKUPASI;Jasa Kemasyarakatan dan Perorangan Bidang Jasa Usaha Makanan /  Pengelolaan Usaha Makanan;JUM.UM01.001.01|Melakukan Komunikasi Dalam Ruang Lingkup Pekerjaan&JUM.UM01.005.01|Melakukan Kebersihan Diri Dan Lingkungan Dalam Pengelolaan Jasa Usaha Makanan Berdasarkan Prinsip Hygine Sanitasi&JUM.UM02.013.01|Menerima Laporan Analisis Menu Dari Asisten Kepala Dapur&JUM.UM02.015.01|Melakukan Manajemen Produksi&JUM.UM03.007.01|Menampilkan Rancangan Pengembangan Jasa Usaha Makanan&JUM.UM03.008.011|Mengawasi Dekorasi Hidangan^Desainer Grafis Muda (Junior Graphic Designer);007/DGM/UN38.2.7/2017;OKUPASI;Bidang Desain Grafis / Desain Komunikasi Visual;M.74100.009.02|Mengoperasikan Perangkat Lunak Desain &M.74100.002.02|Menerapkan Prinsip Dasar Komunikasi&M.74100.010.01|Menciptakan Karya Desain&M.74100.005.01|Menerapkan Desain Brief&M.74100.001.02|Mengaplikasikan Prinsip Dasar Desain^Human Resources Supervisor;006/HRS/UN38.1.7/2017;OKUPASI;Manajemen Sumber Daya Manusia;M.701001.038.01|Melaksanakan Kegiatan Pembelajaran dan Pengembangan &M.701001.057.01|Menyusun Prosedur Operasi Standar Pengelolaan Kinerja&M.701001.065.01|Menyusun Prosedur Operasi Standar Remunerasi di Tingkat Organisasi&M.701001.080.01|Melaksanakan Pemenuhan Hak-hak Normatif Pekerja&Unit Kompetensi|Pilihan&M.701001.005.01|Menyusun Uraian Jabatan&M.701001.008.01|Membuat Rencana Pencarian Sumber Calon Pekerja&M.701001.011.01|Melaksanakan Proses Seleksi Calon Pekerja &M.701001.012.01|Melakukan Penilaian Hasil Seleksi &M.701001.013.01|Melakukan Penawaran Kerja terhadap Calon Pekerja&M.701001.014.01|Melakukan Penempatan Pekerja&M.701001.033.01|Mengidentifikasi Kesenjangan Kompetensi&M.701001.037.01|Menyusun Anggaran Program Pembelajaran dan Pengembangan&M.701001.051.01|Melakukan Pemetaan Potensi dan Kompetensi&M.701001.052.01|Menyusun Rencana Implementasi Pengembangan Karir";


        foreach (explode('^', $data) as $js) {
            $jenisNskema = explode(';', $js);

            // mengecek jenis skema dan membuatnya jika belum ada
            $jenis = Jenis::where('nama', $jenisNskema[2]);
            if (Jenis::where('nama', $jenisNskema[2])->count() == 0) {
                $jenis = Jenis::create([
                    'nama' => $jenisNskema[2]
                ]);
            } else {
                $jenis = $jenis->first();
            }

            // membuat skema
            $jurusan =  Fakultas::where('nama', 'ILIKE', "%teknik%")->first()->getJurusan(false)->random();
            $skema = Skema::create([
                'nama' => $jenisNskema[0],
                'kode' => $jenisNskema[1],
                'sektor' => $jenisNskema[3],
                'jenis_id' => $jenis->id,
                'keterangan' => $faker->text(100),
                'tempat_uji_id' => TempatUji::all()->random()->id,
                'jurusan_id' => $jurusan->id,
                'harga' => (rand(500, 5000) * 1000),
                'kbli' => $faker->numerify('####'),
                'kbji' => $faker->numerify('####'),
                'level_kkni' => $faker->numerify('#'),
                'kode_unit_skkni' => $faker->randomLetter . $faker->randomLetter . $faker->randomLetter,
                'kualifikasi' => $faker->sentence(3),
                'qualification' => $faker->sentence(3)
            ]);

            foreach (explode('&', $jenisNskema[4]) as $u) {
                $udata = explode('|', $u);

                // mengecek unit kompetensi dan membuatnya jika belum ada
                $unit = UnitKompetensi::where('kode', $udata[0]);
                if (UnitKompetensi::where('kode', $udata[0])->count() == 0) {
                    $unit = UnitKompetensi::create([
                        'kode' => $udata[0],
                        'nama' => $udata[1],
                    ]);
                } else {
                    $unit = $unit->first();
                }
                $skema->getSkemaUnit()->attach($unit);

                for ($c = 0; $c < rand(3, 6); $c++) {
                    // membuat elemen kompetensi
                    $ek = ElemenKompetensi::create([
                        'nama' => $faker->text(100),
                        'unit_kompetensi_id' => $unit->id
                    ]);

                    // membuat kriteria
                    for ($i = 0; $i < rand(3, 6); $i++) {
                        Kriteria::create([
                            'elemen_kompetensi_id' => $ek->id,
                            'unjuk_kerja' => $uk = $faker->text(100),
                            'pertanyaan' => substr($uk, 0, strlen($uk) - 2) . '?'
                        ]);
                    }
                }
            }
        }
    }
}
