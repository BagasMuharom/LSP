<?php

Route::prefix('mahasiswa')->group(function () {

    Route::namespace('Pages')->group(function () {

        Route::get('/', [
            'uses' => 'MahasiswaPageController@index',
            'as' => 'mahasiswa'
        ]);

        Route::get('detail/{mahasiswa}', [
            'uses' => 'MahasiswaPageController@show',
            'as' => 'mahasiswa.detail'
        ]);

        Route::get('sertifikat/{mahasiswa}', [
            'uses' => 'MahasiswaPageController@sertifikat',
            'as' => 'mahasiswa.sertifikat'
        ]);
        
        Route::get('uji/{mahasiswa}', [
            'uses' => 'MahasiswaPageController@uji',
            'as' => 'mahasiswa.uji'
        ]);

        Route::get('tambah', [
            'uses' => 'MahasiswaPageController@tambah',
            'as' => 'mahasiswa.tambah'
        ]);

        Route::get('cek', [
            'uses' => 'MahasiswaPageController@cek',
            'as' => 'mahasiswa.cek'
        ]);

    });

    Route::put('edit/{mahasiswa}', [
        'uses' => 'MahasiswaController@update',
        'as' => 'mahasiswa.edit'
    ]);

    Route::post('blokir/{mahasiswa}', [
        'uses' => 'MahasiswaController@blokir',
        'as' => 'mahasiswa.blokir'
    ]);

    Route::post('verifikasi/akun/{mahasiswa}', [
        'uses' => 'MahasiswaController@verifikasiAkun',
        'as' => 'mahasiswa.verifikasi.akun'
    ]);
    
    Route::post('aktifkan/{mahasiswa}', [
        'uses' => 'MahasiswaController@aktifkan',
        'as' => 'mahasiswa.aktifkan'
    ]);

    Route::post('reset/katasandi/{mahasiswa}', [
        'uses' => 'MahasiswaController@resetKataSandi',
        'as' => 'mahasiswa.reset.katasandi'
    ]);

    Route::delete('hapus/{mahasiswa}', [
        'uses' => 'MahasiswaController@destroy',
        'as' => 'mahasiswa.hapus'
    ]);

    Route::post('tambah', [
        'uses' => 'MahasiswaController@create',
        'as' => 'mahasiswa.tambah'
    ]);

    Route::post('tambah-event-mandiri/{mahasiswa}', [
        'uses' => 'MahasiswaController@tambahEventMandiri',
        'as' => 'event.tambah.mahasiswa.mandiri'
    ]);
    
    Route::post('hapus-event-mandiri/{event}/{mahasiswa}', [
        'uses' => 'MahasiswaController@hapusEventMandiri',
        'as' => 'event.hapus.mahasiswa.mandiri'
    ]);

});