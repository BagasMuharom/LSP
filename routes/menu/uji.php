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

    Route::post('verifikasi-persyaratan/{uji}', [
        'uses' => 'UjiController@verifikasiPersyaratan',
        'as' => 'uji.verifikasi.persyaratan'
    ]);

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
    
    Route::get('lihat/portofolio/{uji}/{portofolio}', [
        'uses' => 'UjiController@lihatPortofolio',
        'as' => 'uji.lihat.portofolio'
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
    
    Route::post('inisialisasi/penilaiandiri/{uji}', [
        'uses' => 'UjiController@inisialisasiPenilaianDiri',
        'as' => 'uji.inisialisasi.ulang.penilaiandiri'
    ]);

    Route::post('reset/penilaiandiri/{uji}', [
        'uses' => 'UjiController@resetPenilaianDiri',
        'as' => 'uji.reset.penilaiandiri'
    ]);

    Route::post('hapus/penilaian/{uji}', [
        'uses' => 'UjiController@hapusPenilaian',
        'as' => 'uji.hapus.penilaian'
    ]);
    
    Route::post('inisialisasi/penilaian/{uji}', [
        'uses' => 'UjiController@inisialisasiPenilaian',
        'as' => 'uji.inisialisasi.ulang.penilaian'
    ]);

    Route::post('ubahstatuskelulusan/{uji}', [
        'uses' => 'UjiController@ubahStatusKelulusan',
        'as' => 'uji.ubah.status.kelulusan'
    ]);

    Route::get('troubleshoot/{uji}', [
        'uses' => 'Pages\UjiPageController@troubleshoot',
        'as' => 'uji.troubleshoot'
    ]);

    Route::prefix('mak4')->group(function () {

        Route::get('isi/{uji}', [
            'uses' => 'Pages\UjiPageController@isimak4',
            'as' => 'uji.isi.mak4'
        ]);

        Route::post('isi/{uji}', [
            'uses' => 'UjiController@isimak4',
            'as' => 'uji.isi.mak4'
        ]);

        Route::post('reset/{uji}', [
            'uses' => 'UjiController@resetMak4',
            'as' => 'uji.reset.mak4'
        ]);

    });

    Route::prefix('frai02')->group(function () {

        Route::get('isi/{uji}', [
            'uses' => 'Pages\PenilaianPageController@isiFRAI02',
            'as' => 'uji.isi.fr_ai_02'
        ]);
        
        Route::post('isi/{uji}', [
            'uses' => 'PenilaianController@isiFRAI02',
            'as' => 'uji.isi.fr_ai_02'
        ]);

    });

    Route::prefix('cetak')->namespace('Pages')->group(function () {

        Route::get('apl02/{uji}', [
            'uses' => 'FormPageController@cetakApl02',
            'as' => 'uji.cetak.apl02'
        ]);
        
        Route::get('apl02v2/{uji}', [
            'uses' => 'FormPageController@cetakApl02V2',
            'as' => 'uji.cetak.apl02v2'
        ]);
        
        Route::get('form/pendaftaran/{uji}', [
            'uses' => 'FormPageController@cetakFormPendaftaran',
            'as' => 'uji.cetak.form.pendaftaran'
        ]);

        Route::get('mpa02/{uji}', [
            'uses' => 'FormPageController@cetakMpa02',
            'as' => 'uji.cetak.mpa02'
        ]);
        
        Route::get('mak02/{uji}', [
            'uses' => 'FormPageController@cetakMak02',
            'as' => 'uji.cetak.mak02'
        ]);
        
        Route::get('mak01/{uji}', [
            'uses' => 'FormPageController@cetakMak01',
            'as' => 'uji.cetak.mak01'
        ]);

        Route::get('apl01/{uji}', [
            'uses' => 'FormPageController@cetakApl01',
            'as' => 'uji.cetak.apl01'
        ]);

        Route::get('mak04/{uji}', [
            'uses' => 'FormPageController@cetakMak04',
            'as' => 'uji.cetak.mak04'
        ]);
        
        Route::get('frai02/{uji}', [
            'uses' => 'FormPageController@cetakFRAI02',
            'as' => 'uji.cetak.frai02'
        ]);

        Route::get('frai01/{uji}', [
            'uses' => 'FormPageController@cetakFRAI01',
            'as' => 'uji.cetak.frai01'
        ]);
        
        Route::get('frac01/{uji}', [
            'uses' => 'FormPageController@cetakFRAC01',
            'as' => 'uji.cetak.frac01'
        ]);

        Route::get('frai04/{uji}', [
            'uses' => 'FormPageController@cetakFRAI04',
            'as' => 'uji.cetak.frai04'
        ]);

        Route::get('frai05/{uji}/{c}', [
            'uses' => 'FormPageController@cetakFRAI05',
            'as' => 'uji.cetak.frai05'
        ]);
    });

});