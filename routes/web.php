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
Route::get('/login','AdminController@login');
Route::post('/login-admin','AdminController@login_admin');
Route::get('/logout','AdminController@logout');
Route::get('/list_document','DocumentController@list_document');

Route::get('/home','AdminController@index');
Route::resource('/danhmuc','DanhMucController');
Route::resource('/product','productController');
