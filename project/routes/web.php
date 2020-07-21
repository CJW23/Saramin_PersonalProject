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
Auth::routes();

Route::get('/', 'Web\MainController@index')->name("index");

Route::get('/{path}', 'Web\MainController@originalUrlRedirect');

Route::get('/users/{user:nickname}', 'Web\UserMainController@index')->middleware('auth')->name("dashboard");

Route::get('/users/setting/info', 'Web\UserMainController@userInfo')->middleware('auth')->name("info");

Route::get('/users/setting/nickname', 'Web\UserMainController@userNickname')->middleware('auth')->name("nickname");

Route::get('/users/setting/edit-info', 'Web\UserMainController@userEditInfo')->middleware('auth')->name("editInfo");

Route::get('/users/setting/password', 'Web\UserMainController@userEditPassword')->middleware('auth')->name("password");

Route::get('/users/setting/delete', 'Web\UserMainController@userDelete')->middleware('auth')->name("delete");

Route::post('/users/urls/create', 'Web\UserMainController@createUserUrl')
    ->middleware('auth')->name("createUserUrlRequest");

Route::put('/users/setting/password', 'Api\UserController@editPasswordRequest')
    ->middleware('auth')->name("editPasswordRequest");

Route::put('/users/setting/info', 'Api\UserController@editInfoRequest')
    ->middleware('auth')->name("editInfoRequest");

Route::put('/users/setting/nickname', 'Api\UserController@editNicknameRequest')
    ->middleware('auth')->name("editNicknameRequest");

Route::delete('/users/setting/delete', 'Api\UserController@dropUserRequest')
    ->middleware('auth')->name("dropUserRequest");

////////////////////
Route::get('/test', "TestController@test");
Route::get('/test1', "TestController@test1");
///////////////////
