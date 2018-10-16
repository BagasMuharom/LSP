<?php

use Illuminate\Database\Seeder;
use App\Models\Skema;
use App\Models\User;
use Faker\Factory;
use App\Models\Role;

class AsesorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');
        $asesor = Role::where('nama', Role::ASESOR)->first();
        foreach (Skema::all() as $skema){
            for ($c = 0; $c < rand(2,4); $c++){
                $user = User::create([
                    'nama' => $nama = $faker->unique()->name,
                    'email' => str_replace(' ', '', strtolower($nama)).'@unesa.ac.id',
                    'nip' => $faker->unique()->numerify('################'),
                    'password' => bcrypt('secret')
                ]);
                $user->getUserRole()->attach($asesor);
                $user->getAsesorSkema()->attach($skema);
            }
        }
    }
}
