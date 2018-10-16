<?php

use Illuminate\Database\Seeder;
use App\Models\TempatUji;
use App\Models\Jurusan;
use Faker\Factory;

class TempatUjiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');
        for ($c = 0; $c < rand(10, 15); $c++){
            TempatUji::create([
                'kode' => chr($c + 65).rand(1,8).'.'.$faker->numerify('##').'.'.$faker->numerify('##'),
                'nama' => 'Lab '.substr($lab = ucwords(strtolower($faker->text(25))), 0, strlen($lab) - 2),
                'jurusan_id' => Jurusan::all()->random()->id
            ]);
        }
    }
}
