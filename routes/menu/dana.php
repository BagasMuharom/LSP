<?php

Route::group(['prefix' => 'dana'], function (){
    Route::get('', [
        'uses' => 'Pages\DanaPageController@index',
        'as' => 'dana'
    ]);

    Route::put('add', [
        'uses' => 'DanaController@add',
        'as' => 'dana.add'
    ]);

    Route::patch('update/{dana}', [
        'uses' => 'DanaController@update',
        'as' => 'dana.update'
    ]);
});