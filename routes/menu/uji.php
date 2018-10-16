<?php

Route::prefix('uji')->group(function () {
    
    Route::namespace('Pages')->group(function () {
        
        Route::get('/', [
            'uses' => 'UjiPageController@index',
            'as' => 'uji'
        ]);

        Route::get('detail/{uji}', [
            'uses' => 'UjiPageController@show',
            'as' => 'uji.detail'
        ]);
        
        Route::get('asesmendiri/asesor/{uji}', [
            'uses' => 'UjiPageController@asesmenDiriAsesor',
            'as' => 'uji.asesmendiri.asesor'
        ]);

    });

    Route::post('edit/{uji}', [
        'uses' => 'UjiController@update',
        'as' => 'uji.edit'
    ]);

    Route::post('ekspor', [
        'uses' => 'UjiController@ekspor',
        'as' => 'uji.ekspor'
    ]);
    
    Route::delete('hapus/{uji}', [
        'uses' => 'UjiController@destroy',
        'as' => 'uji.hapus'
    ]);

    Route::post('pendaftaran', [
        'uses' => 'UjiController@store',
        'as' => 'uji.pendaftaran'
    ]);

    Route::get('lihat/syarat/{uji}/{syarat}', [
        'uses' => 'UjiController@lihatSyarat',
        'as' => 'uji.lihat.syarat'
    ]);
    
    Route::get('lihat/bukti-kompetensi/{uji}/{bukti}', [
        'uses' => 'UjiController@lihatBuktiKomepetensi',
        'as' => 'uji.lihat.bukti.kompetensi'
    ]);

    Route::post('update/nilai/asesmendiri/{uji}', [
        'uses' => 'UjiController@updateNilaiAsesmenDiri',
        'as' => 'uji.update.nilai.asesmendiri'
    ]);
    
    Route::post('update/nilai/asesmendiri/asesor/{uji}', [
        'uses' => 'UjiController@updateAsesmenDiriAsesor',
        'as' => 'uji.update.asesmendiri.asesor'
    ]);

    Route::post('reset/penilaian/{uji}', [
        'uses' => 'UjiController@resetPenilaian',
        'as' => 'uji.reset.penilaian'
    ]);
    
    Route::post('reset/penilaiandiri/{uji}', [
        'uses' => 'UjiController@resetPenilaianDiri',
        'as' => 'uji.reset.penilaiandiri'
    ]);

    Route::prefix('cetak')->group(function () {

        Route::get('asesmen/diri/{uji}', [
            'uses' => 'UjiController@cetakAsesmenDiri',
            'as' => 'uji.cetak.asesmen.diri'
        ]);
        
        Route::get('form/pendaftaran/{uji}', [
            'uses' => 'UjiController@cetakFormPendaftaran',
            'as' => 'uji.cetak.form.pendaftaran'
        ]);

        Route::get('mpa02/{uji}', [
            'uses' => 'UjiController@cetakMpa02',
            'as' => 'uji.cetak.mpa02'
        ]);
        
        Route::get('mak02/{uji}', [
            'uses' => 'UjiController@cetakMak02',
            'as' => 'uji.cetak.mak02'
        ]);

        Route::get('apl01/{uji}', [
            'uses' => 'UjiController@cetakApl01',
            'as' => 'uji.cetak.apl01'
        ]);

    });

});