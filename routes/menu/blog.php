<?php

//Route::resource('post', 'PostController');

Route::group(['prefix' => 'blog'], function (){
    Route::get('', [
        'uses' => 'Pages\PostPageController@index',
        'as' => 'blog'
    ]);

    Route::get('detail/{post}', [
        'uses' => 'Pages\PostPageController@detail',
        'as' => 'blog.detail'
    ]);

    Route::post('tinymce/upload', [
        'uses' => 'PostController@tinymceUpload',
        'as' => 'blog.tinymce.upload'
    ]);

    Route::post('update/{post}', [
        'uses' => 'PostController@update',
        'as' => 'blog.update'
    ]);

    Route::get('delete/{post}', [
        'uses' => 'PostController@delete',
        'as' => 'blog.delete'
    ]);

    Route::get('tambah', [
        'uses' => 'Pages\PostPageController@tambah',
        'as' => 'blog.tambah'
    ]);

    Route::put('add', [
        'uses' => 'PostController@add',
        'as' => 'blog.add'
    ]);
});