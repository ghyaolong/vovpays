<?php

Route::group([], function () {
    Route::post('/', 'PayController@index')->name('pay');
    Route::get('{order_no}', 'PayController@queryOrder');
    Route::post('login', 'PhoneLoginController@login'); // 收款助手登录
    Route::get('show', 'PayController@show')->name('pay.show');
});