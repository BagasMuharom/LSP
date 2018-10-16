<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Role::ALL as $role){
            Role::create([
                'nama' => $role
            ]);
        }
    }
}
