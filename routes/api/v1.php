<?php
/**
 * Created by Viktor Melnikov.
 * Date: 03.08.2018
 * GitHub: viktor-melnikov
 */

Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1', 'as' => 'v1.'], function() {

    Route::group(['prefix' => 'user', 'as' => 'user.'], function() {
        Route::get('all', 'UserController@all')->name('all');
        Route::post('', 'UserController@store')->name('store');
    });

    Route::group(['prefix' => 'pay', 'as' => 'pay.'], function() {
        Route::post('transfer', 'PayController@transfer')->name('transfer');
    });

});