<?php

Route::group(['prefix' => 'kuesioner', 'namespace' => 'Pages'], function (){
    Route::get('', [
        'uses' => 'KuesionerPageController@index',
        'as' => 'kuesioner'
    ]);

    Route::get('detail/{kuesioner}', [
        'uses' => 'KuesionerPageController@detail',
        'as' => 'kuesioner.detail'
    ]);

    Route::get('print/{kuesioner}', [
        'uses' => 'KuesionerPageController@print',
        'as' => 'kuesioner.print'
    ]);
});