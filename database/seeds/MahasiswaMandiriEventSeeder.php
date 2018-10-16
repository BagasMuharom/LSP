<?php

use Illuminate\Database\Seeder;
use App\Models\{Mahasiswa, Event};

class MahasiswaMandiriEventSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mandiri = Event::whereHas('getDana', function ($query) {
            $query->where('nama', 'Mandiri');
        })->get();

        foreach ($mandiri as $event) {
            $daftarMahasiswa = Mahasiswa::all()->random(10);

            foreach ($daftarMahasiswa as $mahasiswa) {
                $mahasiswa->getMahasiswaMandiriEvent()->attach($event);
            }
        }
    }

}
