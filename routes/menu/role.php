<?php

Route::group(['prefix' => 'role'], function (){
    Route::get('', [
        'uses' => 'Pages\RolePageController@index',
        'as' => 'role'
    ]);

    Route::post('menu/update', [
        'uses' => 'RoleController@updateMenu',
        'as' => 'role.menu.update'
    ]);

    Route::patch('update', [
        'uses' => 'RoleController@update',
        'as' => 'role.update'
    ]);

    Route::delete('delete', [
        'uses' => 'RoleController@delete',
        'as' => 'role.delete'
    ]);

    Route::put('add', [
        'uses' => 'RoleController@add',
        'as' => 'role.add'
    ]);
});