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
        //账号管理
        Route::get('account/{type}', 'AccountPhoneController@index')->name('court.account');
        Route::post('account', 'AccountPhoneController@store')->name('court.accountAdd');
        Route::post('account/saveStatus', 'AccountPhoneController@saveStatus')->name('court.accountStatus');
        Route::get('account/{id}/edit', 'AccountPhoneController@edit')->name('court.accountEdit');
        Route::delete('account', 'AccountPhoneController@destroy')->name('court.accountDel');
        Route::post('account/check', 'AccountPhoneController@checkUnique')->name('court.check');
        //银行卡账号
        Route::post('accountBank', 'AccountBankCardsController@store')->name('court.accountBankAdd');
        Route::get('accountBank', 'AccountBankCardsController@index')->name('court.accountBank');
        Route::get('accountBank/{id}/edit', 'AccountBankCardsController@edit')->name('court.accountBankEdit');
        Route::post('accountBank/saveStatus', 'AccountBankCardsController@saveStatus')->name('court.accountBankStatus');
        Route::delete('accountBank', 'AccountBankCardsController@destroy')->name('court.accountBankDel');
        Route::post('accountBank/checkBank', 'AccountBankCardsController@checkUnique')->name('court.checkBank');
    });

});