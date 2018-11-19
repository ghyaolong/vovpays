<?php
/**
 * 商户路由
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/7/17
 * Time: 17:39
 */

//Auth::routes();
Route::group([], function ($router) {
    Route::get('login','LoginController@show')->name('user.login');
    Route::post('login','LoginController@login')->name('user.login');
    Route::get('registerShow','LoginController@registerShow')->name('user.registerShow');
    Route::post('register','LoginController@register')->name('user.register');
    Route::get('dropout', 'LoginController@destroy')->name('user.dropout');

    Route::group(['middleware' => 'auth:user'], function () {
        Route::get('/', 'IndexController@index')->name('user');
        Route::any('user', 'IndexController@user')->name('user.user');
        Route::post('editPassword', 'IndexController@editPassword')->name('user.editPassword');
        Route::delete('users','IndexController@destroy')->name('user.destroy');
        Route::get('settlement','IndexController@settlement')->name('user.settlement');
        Route::get('bank','IndexController@bank')->name('user.bank');
        Route::get('order','OrderController@show')->name('user.order');
        Route::get('record','OrderController@show')->name('user.record');
        Route::get('recharge','OrderController@recharge')->name('user.recharge');
        Route::post('addBankCard','BankCardController@add')->name('user.addBankCard');
        Route::get('main','IndexController@main')->name('user.main');
    });

});