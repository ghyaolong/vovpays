<?php

Route::group([], function () {
    Route::post('/', 'PayController@index')->name('pay');
    Route::get('{order_no}', 'PayController@queryOrder');
    Route::get('Pay/show', 'PayController@show')->name('pay.show');
});