<?php

Route::namespace('Pages')->group(function () {

    Route::get('/', [
        'uses' => 'ProfilePageController@index',
        'as' => 'profil.home'
    ]);

    Route::get('profil', [
        'uses' => 'ProfilePageController@profil',
        'as' => 'profil.profil'
    ]);

    Route::get('skema-sertifikasi', [
        'uses' => 'ProfilePageController@skemaSertifikasi',
        'as' => 'profil.skema.sertifikasi'
    ]);
    
    Route::get('skema-sertifikasi/detail/{skema}', [
        'uses' => 'ProfilePageController@detailSkema',
        'as' => 'profil.skema.sertifikasi.detail'
    ]);
    
    Route::get('berita', [
        'uses' => 'ProfilePageController@berita',
        'as' => 'profil.berita'
    ]);
    
    Route::get('berita/{permalink}', [
        'uses' => 'ProfilePageController@post',
        'as' => 'profil.post'
    ]);
    
    Route::get('galeri', [
        'uses' => 'ProfilePageController@galeri',
        'as' => 'profil.galeri'
    ]);
    
    Route::get('galeri/detail/{idgaleri}', [
        'uses' => 'ProfilePageController@fotoGaleri',
        'as' => 'profil.galeri.detail'
    ]);
    
    Route::get('kontak', [
        'uses' => 'ProfilePageController@kontak',
        'as' => 'profil.kontak'
    ]);

    Route::get('pengumuman', [
        'uses' => 'ProfilePageController@pengumuman',
        'as' => 'profil.pengumuman'
    ]);

    Route::get('daftar-event', [
        'uses' => 'ProfilePageController@event',
        'as' => 'profil.event'
    ]);

});