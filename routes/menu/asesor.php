<?php

Route::prefix('asesor')->group(function () {

    Route::namespace('Pages')->group(function () {

        Route::get('/', [
            'uses' => 'AsesorPageController@index',
            'as' => 'asesor'
        ]);

        Route::get('edit/{asesor}', [
            'uses' => 'AsesorPageController@edit',
            'as' => 'asesor.edit'
        ]);

        Route::get('daftaruji/{asesor}', [
            'uses' => 'AsesorPageController@daftarUji',
            'as' => 'asesor.daftar.uji'
        ]);

    });

    Route::post('edit/{asesor}', [
        'uses' => 'AsesorController@update',
        'as' => 'asesor.edit'
    ]);

    Route::prefix('surat-tugas')->group(function () {

        Route::get('lihat/{asesor}/{dir}', [
            'uses' => 'AsesorController@lihatSuratTugas',
            'as' => 'asesor.surat_tugas.lihat'
        ]);

        Route::post('unggah/{asesor}', [
            'uses' => 'AsesorController@unggahSuratTugas',
            'as' => 'asesor.surat_tugas.unggah'
        ]);

        Route::delete('hapus', [
            'uses' => 'AsesorController@hapusSuratTugas',
            'as' => 'asesor.surat_tugas.hapus'
        ]);

    });

});