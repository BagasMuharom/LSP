<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Skema;
use App\Models\Syarat;

class SyaratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');
        foreach (Skema::all() as $skema){
            for ($c = 0; $c < rand(4, 8); $c++){
                Syarat::create([
                    'skema_id' => $skema->id,
                    'nama' => $faker->text(50),
                    'upload' => rand(0, 1) == 0
                ]);
            }
        }
    }
}
