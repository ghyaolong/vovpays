<?php
/**
 * 总后台路由
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/7/17
 * Time: 17:39
 */

//Auth::routes();
Route::group([], function () {
    Route::get('login', 'LoginController@show')->name('admin.login');
    Route::post('login', 'LoginController@login')->name('admin.login');

    Route::group(['middleware' => 'auth:admin'], function () {

        Route::get('menu', 'IndexController@getMenu')->name('admin.menu');

        Route::get('/', 'IndexController@index')->name('admin');
        Route::get('main', 'IndexController@main')->name('admin.main');
        Route::get('rules','RulesController@index')->name('rules.index');
        Route::post('rules','RulesController@store')->name('rules.store');
        Route::put('rules','RulesController@edit')->name('rules.edit');
        Route::get('rules','RulesController@destroy')->name('rules.destroy');
    });
});