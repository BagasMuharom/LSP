<?php

use Illuminate\Database\Seeder;
use App\Models\Dana;
use Faker\Factory;

class DanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');
        foreach (['Mandiri', 'FT', 'PSS'] as $nama){
            Dana::create([
                'nama' => $nama,
                'berulang' => (($nama == 'Mandiri') ? true : false),
                'keterangan' => $faker->unique()->sentence
            ]);
        }
    }
}
