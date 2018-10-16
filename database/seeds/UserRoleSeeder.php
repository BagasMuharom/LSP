<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Menu;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sa = User::create([
            'nama' => 'Smadia',
            'email' => 'sa@email.com',
            'password' => bcrypt('secret')
        ]);

        foreach (Role::all() as $role){
            $user = User::create([
                'nama' => ucwords(strtolower($role->nama)),
                'email' => str_replace(' ', '-', strtolower($role->nama)).'@email.com',
                'password' => bcrypt('secret')
            ]);

            if ($role->nama == Role::ADMIN or $role->nama == Role::SUPER_ADMIN or $role->nama == Role::SERTIFIKASI) {
                $role->getRoleMenu()->attach(Menu::where('nama', Menu::VERIFIKASI)->first()->id);
                $role->getRoleMenu()->attach(Menu::where('nama', Menu::SERTIFIKAT)->first()->id);
            }
            if ($role->nama == Role::ADMIN or $role->nama == Role::SUPER_ADMIN) {
                $role->getRoleMenu()->attach(Menu::where('nama', Menu::UJI)->first()->id);
            }
            if ($role->nama == Role::SUPER_ADMIN) {
                $role->getRoleMenu()->attach(Menu::where('nama', Menu::MAHASISWA)->first()->id);
                $role->getRoleMenu()->attach(Menu::where('nama', Menu::USER)->first()->id);
                $role->getRoleMenu()->attach(Menu::where('nama', Menu::ASESOR)->first()->id);
            }
            $user->getUserRole()->attach($role);
            $sa->getUserRole()->attach($role);
        }
    }

}
