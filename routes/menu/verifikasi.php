<?php

Route::group(['prefix' => 'verifikasi'], function () {

    Route::namespace('Pages')->group(function () {

        Route::get('/', [
            'uses' => 'VerifikasiPageController@index',
            'as' => 'verifikasi' 
        ]);

    });

    Route::post('verifikasi/{uji}', [
        'uses' => 'VerifikasiController@terima',
        'as' => 'verifikasi.terima'
    ]);

    Route::post('tolak/{uji}', [
        'uses' => 'VerifikasiController@tolak',
        'as' => 'verifikasi.tolak'
    ]);
    
    Route::post('reset/{uji}', [
        'uses' => 'VerifikasiController@hapus',
        'as' => 'verifikasi.reset'
    ]);

});
