<?php

use Illuminate\Database\Seeder;
use App\Models\Galeri;
use App\Models\Foto;
use App\Models\User;
use Faker\Factory;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class GaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (scandir(public_path($path = 'images/galeri')) as $fileName){
            if (file_exists(public_path($path.'/'.$fileName)) && $fileName != '.gitignore'){
                File::delete(public_path($path.'/'.$fileName));
                print "Menghapus ".$path.'/'.$fileName."\n";
            }
        }
        print "Continue seeding...\n";

        $faker = Factory::create('id_ID');

        $namaGaleri['Carousel'] = 'Ini adalah carousel yang akan ditampilkan pada halaman awal';
//        for ($c = 0; $c < 10; $c++){
//            $namaGaleri[$faker->unique()->sentence(rand(2, 4))] = $faker->unique()->text;
//        }

        $user = User::all();
        foreach ($namaGaleri as $nama => $keterangan){
            $galeri = Galeri::create([
                'user_id' => $user->random()->id,
                'nama' => $nama,
                'keterangan' => $keterangan,
                'created_at' => $faker->unique()->dateTimeThisYear
            ]);

            for ($c = 0; $c < rand(11, 15); $c++){
                Foto::create([
                    'galeri_id' => $galeri->id,
                    'dir' => 'images/galeri/'.$faker->image(public_path('images/galeri'),1366,768, null, false)
                ]);
            }
        }

        Galeri::carousel()->update([
            'created_at' => Carbon::now()->toDateTimeString()
        ]);
    }
}
