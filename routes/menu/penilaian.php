<?php

Route::group(['prefix' => 'penilaian'], function (){
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
});