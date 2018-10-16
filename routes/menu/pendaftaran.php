<?php

Route::prefix('sertifikasi')->group(function () {
        
    Route::namespace('Pages')->group(function () {

        Route::get('pendaftaran', [
            'uses' => 'UjiPageController@create',
            'as' => 'sertifikasi.daftar'
        ]);

        Route::get('riwayat', [
            'uses' => 'UjiPageController@riwayatSertifikasi',
            'as' => 'sertifikasi.riwayat'
        ]);

        Route::get('asesmendiri/{uji}', [
            'uses' => 'UjiPageController@asesmenDiri',
            'as' => 'sertifikasi.asesmen.diri'
        ]);

    });

});