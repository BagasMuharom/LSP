<?php

Route::prefix('user')->group(function () {

    Route::namespace('Pages')->group(function () {

        Route::get('/', [
            'uses' => 'UserPageController@index',
            'as' => 'user'
        ]);

        Route::get('detail/{user}', [
            'uses' => 'UserPageController@show',
            'as' => 'user.detail'
        ]);

    });

    Route::post('tambah', [
        'uses' => 'UserController@store',
        'as' => 'user.tambah'
    ]);

    Route::put('updaterole/{user}', [
        'uses' => 'UserController@updateRole',
        'as' => 'user.update.role'
    ]);

    Route::put('edit/{user}', [
        'uses' => 'UserController@update',
        'as' => 'user.edit'
    ]);

    Route::delete('hapus/{user}', [
        'uses' => 'UserController@destroy',
        'as' => 'user.hapus'
    ]);

    Route::post('reset/katasandi/{user}', [
        'uses' => 'UserController@resetKataSandi',
        'as' => 'user.reset.katasandi'
    ]);

});