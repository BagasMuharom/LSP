<?php

Route::prefix('sertifikat')->group(function () {

    Route::namespace('Pages')->group(function () {

        Route::get('/', [
            'uses' => 'SertifikatPageController@index',
            'as' => 'sertifikat'
        ]);

        Route::get('tambah/{uji}', [
            'uses' => 'SertifikatPageController@create',
            'as' => 'sertifikat.tambah'
        ]);

        Route::get('detail/{sertifikat}', [
            'uses' => 'SertifikatPageController@show',
            'as' => 'sertifikat.detail'
        ]);

        Route::get('kuesioner/{sertifikat}', [
            'uses' => 'SertifikatPageController@formKuesioner',
            'as' => 'sertifikat.kuesioner.isi'
        ]);

        Route::get('kuesioner/cetak/{sertifikat}', [
            'uses' => 'SertifikatPageController@cetakKuesioner',
            'as' => 'sertifikat.kuesioner.cetak'
        ]);

    });

    Route::post('kuesioner/{sertifikat}', [
        'uses' => 'SertifikatController@isiKuesioner',
        'as' => 'sertifikat.kuesioner.isi'
    ]);

    Route::post('impor', [
        'uses' => 'SertifikatController@import',
        'as' => 'sertifikat.impor'
    ]);

    Route::post('ekspor', [
        'uses' => 'SertifikatController@ekspor',
        'as' => 'sertifikat.ekspor'
    ]);

    Route::post('tambah/{uji}', [
        'uses' => 'SertifikatController@store',
        'as' => 'sertifikat.tambah'
    ]);

    Route::put('edit/{sertifikat}', [
        'uses' => 'SertifikatController@update',
        'as' => 'sertifikat.edit'
    ]);
    
    Route::delete('hapus/{sertifikat}', [
        'uses' => 'SertifikatController@destroy',
        'as' => 'sertifikat.hapus'
    ]);

});
