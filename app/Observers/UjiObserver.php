<?php

namespace App\Observers;

use App\Models\Uji;

class UjiObserver
{
    /**
     * Handle to the uji "created" event.
     *
     * @param  \App\Models\Uji  $uji
     * @return void
     */
    public function created(Uji $uji)
    {
        
    }

    /**
     * Handle the uji "updated" event.
     *
     * @param  \App\Models\Uji  $uji
     * @return void
     */
    public function updated(Uji $uji)
    {

        // jika terverifikasi oleh bagian sertifikasi
        if ($uji->terverifikasi_bag_sertifikasi) {
            // jika tempat uji kosong
            if ($uji->getPenilaianDiri()->count() === 0) {
                // membuat penilaian diri kosongan
                $uji->initPenilaianDiri();
            }
        }
    }

    /**
     * Handle the uji "deleted" event.
     *
     * @param  \App\Models\Uji  $uji
     * @return void
     */
    public function deleted(Uji $uji)
    {
        //
    }
}
