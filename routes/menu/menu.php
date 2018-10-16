<?php

Route::group(['prefix' => 'menu'], function (){
    Route::get('', [
        'uses' => 'Pages\MenuPageController@index',
        'as' => 'menu'
    ]);

    Route::patch('update', [
        'uses' => 'MenuController@update',
        'as' => 'menu.update'
    ]);
});