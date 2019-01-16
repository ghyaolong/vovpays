<?php
/**
 * 场外第三方挂号
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/7/17
 * Time: 17:39
 */

//Auth::routes();
Route::group([], function ($router) {

    Route::get('login', 'LoginController@show')->name('court.login');
    Route::post('login', 'LoginController@login')->name('court.login');
    Route::get('signOut', 'LoginController@destroy')->name('court.signOut');

    Route::group(['middleware' => 'auth:court'], function () {
        Route::get('/', 'IndexController@show')->name('court.index');
        Route::get('rate', 'IndexController@rate')->name('court.rate');
        Route::get('info', 'AgentController@index')->name('court.info');
        Route::get('order', 'OrderController@index')->name('court.order');
        Route::get('order/{id}/show', 'OrderController@show')->name('court.show');
    });

});