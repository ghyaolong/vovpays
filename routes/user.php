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
        Route::any('user', 'IndexController@user')->name('user.user');
        Route::post('editPassword', 'IndexController@editPassword')->name('user.editPassword');
        Route::delete('users','IndexController@destroy')->name('user.destroy');
        Route::get('main','IndexController@main')->name('user.main');
        Route::get('validator','IndexController@validator')->name('user.validator');
        Route::get('api','IndexController@api')->name('user.api');
        //订单
        Route::get('order','OrderController@show')->name('user.order');
        Route::get('invoice','OrderController@invoice')->name('user.invoice');
        Route::get('recharge','OrderController@recharge')->name('user.recharge');
        //银行卡管理
        Route::post('store','BankCardController@store')->name('user.store');
        Route::get('bankCard/{id}','BankCardController@bankCard')->name('user.bankCard');
        Route::delete('del','BankCardController@destroy')->name('users.destroy');
        Route::get('{id}/edit','BankCardController@edit')->name('users.edit');
        Route::post('saveStatus','BankCardController@saveStatus')->name('users.saveStatus');
        //提现
        Route::get('clearing/{id}','WithdrawsController@clearing')->name('user.clearing');
        Route::post('apply','WithdrawsController@store')->name('user.apply');
//        Route::any('withdraws/{id}','WithdrawsController@index')->name('user.withdraws');
        Route::any('withdraws','WithdrawsController@index')->name('user.withdraws');
        //支付宝
        Route::get('alipay','AccountPhoneController@index')->name('user.alipay');
        Route::get('wechat','AccountPhoneController@index')->name('user.wechat');
        Route::post('alipayadd','AccountPhoneController@store')->name('user.alipayadd');
        Route::post('accountStatus','AccountPhoneController@saveStatus')->name('user.accountStatus');
        Route::get('{id}/accountEdit','AccountPhoneController@edit')->name('user.accountEdit');
        Route::delete('accountDel','AccountPhoneController@destroy')->name('user.accountDel');
    });

});