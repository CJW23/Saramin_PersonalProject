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

Route::get('/', 'Web\MainController@index')->name("index");

Route::get('/test', "TestController@test");
Route::get('/test1', "TestController@test1");
Auth::routes();


Route::get('/{path}', 'Web\MainController@originalUrlRedirect');
Route::get('/users/{user:nickname}', 'Web\UserMainController@index')->middleware('auth');
Route::get('/users/edit/{user:nickname}', 'Web\UserMainController@userInfo')->middleware('auth')->name("info");
