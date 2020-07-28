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

Route::prefix('/admin')->middleware('admin.auth')->group(function () {
    Route::get('/', "Web\AdminController@index")
        ->name("adminIndex");

    Route::get('/users', "Web\AdminController@manageUser")
        ->name("adminUser");

    Route::delete('/users/{userId}', "Api\AdminApiController@deleteUser")
        ->name("adminDeleteUser");

    Route::put('/users/give-auth/{userId}', "Api\AdminApiController@giveAuth")
        ->name("adminGiveAuth");

    Route::put('/users/withdraw-auth/{userId}', "Api\AdminApiController@withdrawAuth")
        ->name("adminWithdrawAuth");

    Route::get('/urls', "Web\AdminController@manageUrl")
        ->name("adminUrl");

    Route::delete('/urls/{urlId}', "Api\AdminApiController@deleteUrl")
        ->name("adminDeleteUrl");

    Route::post('/ban', "Api\AdminApiController@createBanUrl")
        ->name("adminCreateBanUrl");
});


Route::get('/', 'Web\MainController@index')->middleware('guest.check')
    ->name("index");

Route::prefix('/users')->middleware('user.auth')->group(function () {
    Route::get('/', 'Web\UserController@index')
        ->name("dashboard");

    Route::get('/setting/info', 'Web\UserController@userInfo')
        ->name("info");

    Route::get('/setting/nickname', 'Web\UserController@userNickname')
        ->name("nickname");

    Route::get('/setting/edit-info', 'Web\UserController@userEditInfo')
        ->name("editInfo");

    Route::get('/setting/password', 'Web\UserController@userEditPassword')
        ->name("password");

    Route::get('/setting/delete', 'Web\UserController@userDelete')
        ->name("delete");

    Route::post('/urls/create', 'Api\UrlApiController@createUserUrl')
        ->name("createUserUrlRequest");

    Route::put('/setting/password', 'Api\UserApiController@editPasswordRequest')
        ->name("editPasswordRequest");

    Route::put('/setting/info', 'Api\UserApiController@editInfoRequest')
        ->name("editInfoRequest");

    Route::put('/setting/nickname', 'Api\UserApiController@editNicknameRequest')
        ->name("editNicknameRequest");

    Route::delete('/setting/delete', 'Api\UserApiController@dropUserRequest')
        ->name("dropUserRequest");

    Route::delete('/urls/delete', 'Api\UrlApiController@deleteUserUrl')
        ->name('deleteUserUrl');

    Route::get('/data/total', 'Api\UrlApiController@totalUserUrlData')
        ->name('totalUserUrlData');

    Route::get('/data/url/{urlId}', 'Api\UrlApiController@individualUserUrlData');
});
Route::get('/test/makeuser', "TestController@makeuser");
Route::post('/test/makeurl', "TestController@makeurl");
Route::get('/{path}', 'Web\MainController@originalUrlRedirect');

////////////////////
Route::get('/test', "TestController@test");
Route::get('/test1', "TestController@test1");
///////////////////
