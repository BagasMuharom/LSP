<?php

Route::group(['prefix' => 'penilaian'], function () {

    Route::get('', [
        'uses' => 'Pages\PenilaianPageController@index',
        'as' => 'penilaian'
    ]);

    Route::get('nilai/{uji}', [
        'uses' => 'Pages\PenilaianPageController@nilai',
        'as' => 'penilaian.nilai'
    ]);

    Route::post('update/{uji}', [
        'uses' => 'PenilaianController@nilai',
        'as' => 'penilaian.update'
    ]);

    Route::post('konfirmasi/{uji}', [
        'uses' => 'PenilaianController@konfirmasi',
        'as' => 'penilaian.konfirmasi'
    ]);
    
    Route::post('batalkan-konfirmasi/{uji}', [
        'uses' => 'PenilaianController@batalkanKonfirmasi',
        'as' => 'penilaian.batalkan.konfirmasi'
    ]);

    Route::get('fr-ai-04/{uji}', [
        'uses' => 'Pages\PenilaianPageController@FRAI04',
        'as' => 'penilaian.fr-ai-04'
    ]);

    Route::post('fr-ai-04/eval/{uji}', [
        'uses' => 'PenilaianController@evaluasiPortofolio',
        'as' => 'penilaian.eval.fr-ai-04'
    ]);

});