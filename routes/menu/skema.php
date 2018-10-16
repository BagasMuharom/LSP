<?php

Route::group(['prefix' => 'skema'], function () {

    Route::post('daftar', [
        'uses' => 'SkemaController@getDaftarSkema',
        'as' => 'skema.daftar'
    ]);

    Route::get('', [
        'uses' => 'Pages\SkemaPageController@index',
        'as' => 'skema'
    ]);

    Route::get('tambah', [
        'uses' => 'Pages\SkemaPageController@tambah',
        'as' => 'skema.tambah'
    ]);

    Route::put('add', [
        'uses' => 'SkemaController@add',
        'as' => 'skema.add'
    ]);

    Route::get('detail/{id}', [
        'uses' => 'Pages\SkemaPageController@detail',
        'as' => 'skema.detail'
    ]);

    Route::delete('delete', [
        'uses' => 'SkemaController@delete',
        'as' => 'skema.delete'
    ]);

    Route::patch('update', [
        'uses' => 'SkemaController@update',
        'as' => 'skema.update'
    ]);

    Route::get('jenis', [
        'uses' => 'Pages\SkemaPageController@jenis',
        'as' => 'skema.jenis'
    ]);

    Route::patch('jenis/update', [
        'uses' => 'SkemaController@updateJenis',
        'as' => 'skema.jenis.update'
    ]);

    Route::put('jenis/add', [
        'uses' => 'SkemaController@addJenis',
        'as' => 'skema.jenis.add'
    ]);

    Route::delete('jenis/delete', [
        'uses' => 'SkemaController@deleteJenis',
        'as' => 'skema.jenis.delete'
    ]);

    Route::post('restore', [
        'uses' => 'SkemaController@restore',
        'as' => 'skema.restore'
    ]);

    Route::post('syarat', [
        'uses' => 'SkemaController@updateSyarat',
        'as' => 'skema.syarat.update'
    ]);
});
