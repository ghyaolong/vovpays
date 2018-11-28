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
        Route::post('add', 'UserController@add')->name('agent.add');
        Route::post('check', 'UserController@checkUnique')->name('agent.check');

        Route::get('info', 'AgentController@index')->name('agent.info');

        Route::get('order', 'OrderController@index')->name('agent.order');

        Route::get('bankCard', 'BankCardController@index')->name('agent.bankCard');

        //提现
        Route::get('clearing','WithdrawsController@clearing')->name('agent.clearing');
        Route::post('apply','WithdrawsController@store')->name('agent.apply');
        Route::any('withdraws','WithdrawsController@index')->name('agent.withdraws');

    });

});