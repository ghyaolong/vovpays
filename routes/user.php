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
        Route::get('index', 'IndexController@index')->name('user.index');
        Route::any('index/user', 'IndexController@user')->name('user.user');
        Route::post('index/editPassword', 'IndexController@editPassword')->name('user.editPassword');
        Route::get('index/main','IndexController@main')->name('user.main');
        Route::get('index/validator','IndexController@validator')->name('user.validator');
        Route::get('index/api','IndexController@api')->name('user.api');
        //订单
        Route::get('order','OrderController@show')->name('user.order');
        Route::get('order/invoice','OrderController@invoice')->name('user.invoice');
        Route::get('order/recharge','OrderController@recharge')->name('user.recharge');
        //银行卡管理
        Route::post('bankCard/store','BankCardController@store')->name('user.store');
        Route::get('bankCard/{id}','BankCardController@bankCard')->name('user.bankCard');
        Route::delete('bankCard','BankCardController@destroy')->name('users.destroy');
        Route::get('bankCard/{id}/edit','BankCardController@edit')->name('users.edit');
        Route::post('bankCard/saveStatus','BankCardController@saveStatus')->name('users.saveStatus');
        //提现
        Route::any('withdraws','WithdrawsController@index')->name('user.withdraws');
        Route::get('withdraws/{id}','WithdrawsController@clearing')->name('user.clearing');
        Route::post('withdraws/store','WithdrawsController@store')->name('user.apply');
        //账号管理
        Route::get('account/{type}','AccountPhoneController@index')->name('user.account');
        Route::post('account','AccountPhoneController@store')->name('user.accountAdd');
        Route::post('account/saveStatus','AccountPhoneController@saveStatus')->name('user.accountStatus');
        Route::get('account/{id}/edit','AccountPhoneController@edit')->name('user.accountEdit');
        Route::delete('account','AccountPhoneController@destroy')->name('user.accountDel');
        Route::post('account/check','AccountPhoneController@checkUnique')->name('user.check');
    });

});