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

        Route::get('bankCard', 'BankCardController@index')->name('agent.bankCard');
        Route::post('bankCard','BankCardController@store')->name('agent.store');

        //提现
        Route::any('withdraws','WithdrawsController@index')->name('agent.withdraws');
        Route::get('withdraws/clearing','WithdrawsController@clearing')->name('agent.clearing');
        Route::post('withdraws/apply','WithdrawsController@store')->name('agent.apply');

    });

});