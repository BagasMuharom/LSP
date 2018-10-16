<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\User;
use App\Models\Role;

class MenuRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('nama', Role::SUPER_ADMIN)->first();
        foreach (Menu::all() as $menu){
            $role->getRoleMenu()->attach($menu);
        }
    }
}
