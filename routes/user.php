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
        Route::get('/', 'HomeController@index')->name('user');
        Route::any('user', 'HomeController@user')->name('user.user');
        Route::post('editPassword', 'HomeController@editPassword')->name('user.editPassword');
        Route::delete('users','HomeController@destroy')->name('user.destroy');
        Route::get('settlement','HomeController@settlement')->name('user.settlement');
        Route::get('bank','HomeController@bank')->name('user.bank');
        Route::get('order','OrderController@show')->name('user.order');
        Route::get('record','OrderController@show')->name('user.record');
    });

//    $router->get('login', 'LoginController@showLoginForm')->name('login');
//    $router->post('login', 'LoginController@login');
//    $router->post('logout', 'LoginController@logout')->name('logout');

// Registration Routes...
//    $router->get('register', 'RegisterController@showRegistrationForm')->name('register');
//    $router->post('register', 'RegisterController@register');

// Password Reset Routes...
//    $router->get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
//    $router->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//    $router->get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
//    $router->post('password/reset', 'ResetPasswordController@reset');
});