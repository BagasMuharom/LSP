<?php

Route::group(['prefix' => 'fjp'], function (){
    Route::get('', [
        'uses' => 'Pages\FakultasJurusanProdiPageController@index',
        'as' => 'fjp'
    ]);

    Route::post('sinkron', [
        'uses' => 'FakultasJurusanProdiController@sinkron',
        'as' => 'fjp.sinkron'
    ]);
});