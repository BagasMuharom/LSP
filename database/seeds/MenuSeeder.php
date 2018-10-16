<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Menu::ALL as $menu){
            Menu::create([
                'route' => $menu,
                'nama' => ucwords(str_replace('-', ' ', $menu))
            ]);
        }
    }
}
