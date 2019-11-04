<?php

Route::group(['prefix' => 'unit'], function (){
    Route::get('', [
        'uses' => 'Pages\UnitPageController@index',
        'as' => 'unit'
    ]);

    Route::get('lihat-elemen/{id}', [
        'uses' => 'Pages\UnitPageController@elemen',
        'as' => 'unit.elemen'
    ]);

    Route::post('elemen/kriteria/update', [
        'uses' => 'UnitController@updateKriteria',
        'as' => 'unit.elemen.kriteria.update'
    ]);

    Route::delete('elemen/delete', [
        'uses' => 'UnitController@deleteElemen',
        'as' => 'unit.elemen.delete'
    ]);

    Route::patch('elemen/update', [
        'uses' => 'UnitController@updateElemen',
        'as' => 'unit.elemen.update'
    ]);

    Route::put('elemen/add', [
        'uses' => 'UnitController@addElemen',
        'as' => 'unit.elemen.add'
    ]);

    Route::get('daftar-skema', [
        'uses' => 'SkemaController@getDaftarSkema',
        'as' => 'unit.daftarskema'
    ]);

    Route::patch('update', [
        'uses' => 'UnitController@update',
        'as' => 'unit.update'
    ]);

    Route::delete('delete', [
        'uses' => 'UnitController@delete',
        'as' => 'unit.delete'
    ]);

    Route::post('restore', [
        'uses' => 'UnitController@restore',
        'as' => 'unit.restore'
    ]);

    Route::put('pertanyaan-observasi/tambah/{unit}', [
        'uses' => 'UnitController@tambahPertanyaanObservasi',
        'as' => 'unit.pertanyaan-observasi.tambah'
    ]);
    
    Route::post('pertanyaan-observasi/edit', [
        'uses' => 'UnitController@editPertanyaanObservasi',
        'as' => 'unit.pertanyaan-observasi.edit'
    ]);
    
    Route::delete('pertanyaan-observasi/hapus', [
        'uses' => 'UnitController@hapusPertanyaanObservasi',
        'as' => 'unit.pertanyaan-observasi.hapus'
    ]);

});