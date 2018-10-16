<?php

namespace App\Observers;

use App\Models\Sertifikat;
use Carbon\Carbon;

class SertifikatObserver
{
    /**
     * Handle to the models sertifikat "created" event.
     *
     * @param  \App\Models\Sertifikat  $sertifikat
     * @return void
     */
    public function created(Sertifikat $sertifikat)
    {
        if (!is_null($sertifikat->uji_id)) {
            $sertifikat->update([
                'skema_id' => $sertifikat->getUji(false)->getSkema(false)->id,
                'nama_pemegang' => $sertifikat->getUji(false)->getMahasiswa(false)->nama
            ]);
        }

        $sertifikat->update([
            'tahun_cetak' => Carbon::parse($sertifikat->tanggal_cetak)->year
        ]);
        
        $sertifikat->update([
            'nomor_sertifikat' => $this->generateNomorSertifikat($sertifikat),
            'nomor_registrasi' => $this->generateNomorRegistrasi($sertifikat)
        ]);
    }

    /**
     * Mendapatkan nomor registrasi dari sertifikat
     *
     * @param Sertifikat $sertifikat
     * @return string
     */
    private function generateNomorSertifikat(Sertifikat $sertifikat)
    {
        $skema = $sertifikat->getSkema(false);

        return $skema->kbli . '.' . $skema->kbji . '.' . $skema->level_kkni . '.' . $sertifikat->no_urut_cetak . '.' . $sertifikat->tahun_cetak;
    }

    private function generateNomorRegistrasi(Sertifikat $sertifikat)
    {
        $skema = $sertifikat->getSkema(false);
        
        return $skema->kode_unit_skkni . '.249.' . $sertifikat->no_urut_skema . '.' . $sertifikat->tahun;
    }

    /**
     * Handle the models sertifikat "updated" event.
     *
     * @param  \App\Models\Sertifikat  $sertifikat
     * @return void
     */
    public function updated(Sertifikat $sertifikat)
    {
        if (!session()->has('update_sertifikat')) {
            session()->put('update_sertifikat', false);
            $sertifikat->update([
                'tahun_cetak' => Carbon::parse($sertifikat->tanggal_cetak)->year
            ]);
            
            $sertifikat->update([
                'nomor_sertifikat' => $this->generateNomorSertifikat($sertifikat),
                'nomor_registrasi' => $this->generateNomorRegistrasi($sertifikat)
            ]);
        }
        else {
            session()->forget('update_sertifikat');
        }
    }

    /**
     * Handle the models sertifikat "deleted" event.
     *
     * @param  \App\Models\Sertifikat  $sertifikat
     * @return void
     */
    public function deleted(Sertifikat $sertifikat)
    {
        //
    }
}
