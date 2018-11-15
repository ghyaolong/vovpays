<?php

Route::group([], function () {
    Route::post('/', 'PayController@index')->name('pay');
});