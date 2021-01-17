<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('index', 'PageController@getIndex')->name('trang-chu');

Route::get('loai-san-pham/{type}', 'PageController@getLoaisp')->name('loaisanpham');

Route::get('chi-tiet-san-pham/{id}', 'PageController@getChitiet')->name('chitietsanpham');

Route::get('lien-he', 'PageController@getLienhe')->name('lienhe');

Route::get('gioi-thieu', 'PageController@getGioithieu')->name('gioithieu');

Route::get('add-to-cart/{id}', 'PageController@getAddtoCart')->name('themgiohang');

Route::get('del-cart/{id}', 'PageController@getDelItemCart')->name('xoagiohang');

Route::get('dat-hang', 'PageController@getCheckout')->name('checkout');

Route::post('dat-hang', 'PageController@postCheckout')->name('checkout');

Route::get('dang-nhap', 'PageController@getLogin')->name('login');

Route::post('dang-nhap', 'PageController@postLogin')->name('login');

Route::get('dang-ky', 'PageController@getSignin')->name('signin');

Route::post('dang-ky', 'PageController@postSignin')->name('signin');

Route::get('dang-xuat', 'PageController@postLogout')->name('logout');

Route::get('search', 'PageController@getSearch')->name('search');
