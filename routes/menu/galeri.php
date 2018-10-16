<?php

Route::group(['prefix' => 'admin/galeri'], function (){
    Route::get('', [
        'uses' => 'Pages\GaleriPageController@index',
        'as' => 'galeri'
    ]);

    Route::patch('update/{galeri}', [
        'uses' => 'GaleriController@update',
        'as' => 'galeri.update'
    ]);

    Route::get('foto/{galeri}', [
        'uses' => 'Pages\GaleriPageController@foto',
        'as' => 'galeri.foto'
    ]);

    Route::delete('foto/delete', [
        'uses' => 'GaleriController@deleteFoto',
        'as' => 'galeri.delete.foto'
    ]);

    Route::put('create', [
        'uses' => 'GaleriController@create',
        'as' => 'galeri.create'
    ]);

    Route::delete('delete', [
        'uses' => 'GaleriController@delete',
        'as' => 'galeri.delete'
    ]);
});