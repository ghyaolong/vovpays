<?php

Route::group([], function () {
    Route::post('/', 'PayController@index')->name('pay');
    Route::get('{order_no}', 'PayController@queryOrder');
    Route::get('show', 'PayController@show')->name('pay.show');
    Route::get('h5pay/{orderNo}','PayController@h5pay')->name('pay.h5pay');
});