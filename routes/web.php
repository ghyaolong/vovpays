<?php
/**
 * 官网路由
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/7/17
 * Time: 17:39
 */

Route::get('/', function () {
    return view('Home/welcome');
});
Route::get('home2', function () {
    return view('Home/welcome2');
});