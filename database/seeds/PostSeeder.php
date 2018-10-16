<?php

use Illuminate\Database\Seeder;
use App\Models\Post;
use Faker\Factory;
use App\Models\Menu;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');
        $roles = Menu::findByRoute(Menu::BLOG)->getRoleMenu(false);
        foreach ($roles as $role) {
            foreach ($role->getUserRole(false) as $user) {
                for ($c = 0; $c < rand(15, 25); $c++) {
                    Post::create([
                        'judul' => $judul = $faker->unique()->realText(100),
                        'permalink' => Post::generatePermalink($judul),
                        'isi' => $faker->unique()->realText(2000),
                        'penulis_id' => $user->id,
                        'created_at' => $faker->dateTimeThisYear
                    ]);
                }
            }
        }
    }
}
