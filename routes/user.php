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
        //用户管理，密码
        Route::get('/', 'IndexController@index')->name('user');
        Route::any('user', 'IndexController@user')->name('user.user');
        Route::post('editPassword', 'IndexController@editPassword')->name('user.editPassword');
        Route::delete('users','IndexController@destroy')->name('user.destroy');
        Route::get('main','IndexController@main')->name('user.main');
        //订单
        Route::get('order','OrderController@show')->name('user.order');
        Route::get('recharge','OrderController@recharge')->name('user.recharge');
        //银行卡管理
        Route::post('store','BankCardController@store')->name('user.store');
        Route::get('bankCard/{id}','BankCardController@bankCard')->name('user.bankCard');
        Route::delete('del','BankCardController@destroy')->name('users.destroy');
        Route::get('{id}/edit','BankCardController@edit')->name('users.edit');
        Route::post('saveStatus','BankCardController@saveStatus')->name('users.saveStatus');
        //提现
        Route::get('clearing','WithdrawsController@clearing')->name('user.clearing');
        Route::get('withdraws','WithdrawsController@index')->name('user.withdraws');
    });

});