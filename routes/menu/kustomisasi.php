<?php

Route::group(['prefix' => 'kustomisasi'], function (){
    Route::get('', [
        'uses' => 'Pages\KustomisasiPageController@index',
        'as' => 'kustomisasi'
    ]);

    Route::post('update/{kustomisasi}', [
        'uses' => 'KustomisasiController@update',
        'as' => 'kustomisasi.update'
    ]);

    Route::post('update/file/{kustomisasi}', [
        'uses' => 'KustomisasiController@updateFile',
        'as' => 'kustomisasi.update.file'
    ]);
});