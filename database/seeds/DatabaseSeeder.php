<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(FakultasJurusanProdiSeeder::class);
        $this->call(MahasiswaSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(UserRoleSeeder::class);
        $this->call(TempatUjiSeeder::class);
        $this->call(JenisSkemaUnitElemenSeeder::class);
        $this->call(AsesorSeeder::class);
        $this->call(SyaratSeeder::class);
        $this->call(DanaSeeder::class);
        $this->call(EventSeeder::class);
        // $this->call(UjiSeeder::class);
        $this->call(KuesionerSeeder::class);
        $this->call(MahasiswaMandiriEventSeeder::class);
        $this->call(MenuRoleSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(KustomisasiSeeder::class);
        $this->call(GaleriSeeder::class);
    }
}
