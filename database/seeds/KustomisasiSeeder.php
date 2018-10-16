<?php

use Illuminate\Database\Seeder;
use App\Models\Kustomisasi;

class KustomisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Kustomisasi::ALL as $kustomisasi){
            if (Kustomisasi::where('key', $kustomisasi)->count() > 0)
                continue;
                
            Kustomisasi::create([
                'key' => $kustomisasi,
                'user_id' => 1,
                'value' => ''
            ]);
        }

        Kustomisasi::where('key', Kustomisasi::NAMA)->update([
            'value' => 'LSP UNESA'
        ]);
        
        Kustomisasi::where('key', Kustomisasi::LOGO)->update([
            'value' => 'images/kustomisasi/logo.png'
        ]);

        Kustomisasi::where('key', Kustomisasi::EMAIL)->update([
            'value' => 'lsp@unesa.ac.id'
        ]);
    }
}
