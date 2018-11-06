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
    Route::get('dropout', 'LoginController@destroy')->name('admin.dropout');
    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('/', 'IndexController@index')->name('admin');
        //菜单
        Route::get('rules','RulesController@index')->name('rules.index');
        Route::post('rules','RulesController@store')->name('rules.store');
        Route::get('rules/{id}/edit', 'RulesController@edit')->name('rules.edit');
        Route::delete('rules','RulesController@destroy')->name('rules.destroy');
        Route::post('rules/saveCheck','RulesController@saveCheck')->name('rules.saveCheck');
        //角色
        Route::get('roles','RolesController@index')->name('roles.index');
        Route::post('roles','RolesController@store')->name('roles.store');
        Route::get('roles/{id}/edit', 'RolesController@edit')->name('roles.edit');
        Route::delete('roles','RolesController@destroy')->name('roles.destroy');
        //权限分配
        Route::get('roles/{role_id}/rules','RolesController@getRules')->name('getRules');
        Route::put('roles/{role_id}/rules','RolesController@storeRules')->name('setRules');
        //管理员
        Route::get('admins','AdminsController@index')->name('admins.index');
        Route::post('admins','AdminsController@store')->name('admins.store');
        Route::get('admins/{id}/edit', 'AdminsController@edit')->name('admins.edit');
        Route::delete('admins','AdminsController@destroy')->name('admins.destroy');
    });
});