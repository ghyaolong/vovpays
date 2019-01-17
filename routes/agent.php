<?php
/**
 * 代理商路由
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/7/17
 * Time: 17:39
 */

//Auth::routes();
Route::group([], function ($router) {

    Route::get('login', 'LoginController@show')->name('agent.login');
    Route::post('login', 'LoginController@login')->name('agent.login');
    Route::get('signOut', 'LoginController@destroy')->name('agent.signOut');

    Route::group(['middleware' => 'auth:agent'], function () {

        Route::get('/', 'IndexController@show')->name('agent.index');
        Route::get('extension', 'IndexController@extension')->name('agent.extension');
        Route::get('rate', 'IndexController@rate')->name('agent.rate');

        Route::get('user', 'UserController@index')->name('agent.user');
        Route::post('user', 'UserController@add')->name('agent.add');
        Route::post('user/check', 'UserController@checkUnique')->name('agent.check');
        Route::post('user/saveStatus', 'UserController@saveStatus')->name('agent.saveStatus');

        Route::get('info', 'AgentController@index')->name('agent.info');

        Route::get('order', 'OrderController@index')->name('agent.order');
        Route::get('order/{id}/show', 'OrderController@show')->name('order.show');

        Route::get('bankCard', 'BankCardController@index')->name('agent.bankCard');
        Route::post('bankCard','BankCardController@store')->name('agent.store');
        Route::get('bankCard/{id}/edit','BankCardController@edit')->name('agent.edit');
        Route::post('bankCard/saveStatus','BankCardController@saveStatus')->name('agent.saveStatus');
        Route::delete('bankCard','BankCardController@destroy')->name('agent.destroy');

        //提现
        Route::any('withdraws','WithdrawsController@index')->name('agent.withdraws');
        Route::get('withdraws/clearing','WithdrawsController@clearing')->name('agent.clearing');
        Route::post('withdraws/apply','WithdrawsController@store')->name('agent.apply');

        //账号管理
        Route::get('account/{type}','AccountPhoneController@index')->name('agent.account');
        Route::post('account','AccountPhoneController@store')->name('agent.accountAdd');
        Route::post('account/saveStatus','AccountPhoneController@saveStatus')->name('agent.accountStatus');
        Route::get('account/{id}/edit','AccountPhoneController@edit')->name('agent.accountEdit');
        Route::delete('account','AccountPhoneController@destroy')->name('agent.accountDel');
        Route::post('account/check','AccountPhoneController@checkUnique')->name('agent.check');
        //银行卡账号
        Route::post('accountBank','AccountBankCardsController@store')->name('agent.accountBankAdd');
        Route::get('accountBank','AccountBankCardsController@index')->name('agent.accountBank');
        Route::get('accountBank/{id}/edit','AccountBankCardsController@edit')->name('agent.accountBankEdit');
        Route::post('accountBank/saveStatus','AccountBankCardsController@saveStatus')->name('agent.accountBankStatus');
        Route::delete('accountBank','AccountBankCardsController@destroy')->name('agent.accountBankDel');
        Route::post('accountBank/checkBank','AccountBankCardsController@checkUnique')->name('agent.checkBank');

    });

});