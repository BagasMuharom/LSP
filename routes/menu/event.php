<?php

Route::group(['prefix' => 'event'], function (){

    Route::get('', [
        'uses' => 'Pages\EventPageController@index',
        'as' => 'event'
    ]);

    Route::get('detail/{event}', [
        'uses' => 'Pages\EventPageController@detail',
        'as' => 'event.detail'
    ]);

    Route::get('daftaruji/{event}', [
        'uses' => 'Pages\EventPageController@daftarUji',
        'as' => 'event.daftaruji'
    ]);

    Route::patch('update/{event}', [
        'uses' => 'EventController@update',
        'as' => 'event.update'
    ]);

    Route::put('add', [
        'uses' => 'EventController@add',
        'as' => 'event.add'
    ]);

    Route::delete('delete/{event}', [
        'uses' => 'EventController@delete',
        'as' => 'event.delete'
    ]);

    Route::post('print/{event}', [
        'uses' => 'EventController@print',
        'as' => 'event.berita-acara.print'
    ]);

    Route::get('cetak/mak06/{event}', [
        'uses' => 'EventController@cetakMak06',
        'as' => 'event.cetak.mak06'
    ]);

    Route::post('daftar', [
        'uses' => 'EventController@getDaftarEvent',
        'as' => 'event.daftar'
    ]);

});