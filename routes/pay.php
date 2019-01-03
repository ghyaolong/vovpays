<?php

Route::group([], function () {
    Route::post('/', 'PayController@index')->name('pay');
    Route::get('{order_no}', 'PayController@queryOrder');
});