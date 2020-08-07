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

    Route::get('/ban', "Web\AdminController@manageBanUrl")
        ->name("adminBanUrl");

    Route::post('/ban', "Api\AdminApiController@createBanUrl")
        ->name("adminCreateBanUrl");

    Route::delete('/ban/{banUrlId}', "Api\AdminApiController@deleteBanUrl")
        ->name("adminDeleteBanUrl");
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

    Route::post('/setting/checknickname', 'Api\UserApiController@checkNickname')
        ->name("checknickname");

    Route::get('/setting/delete', 'Web\UserController@userDelete')
        ->name("delete");

    Route::post('/urls/create', 'Api\UrlApiController@createUserUrl')
        ->name("createUserUrlRequest");

    Route::put('/setting/password', 'Api\UserApiController@editPassword')
        ->name("editPasswordRequest");

    Route::put('/setting/info', 'Api\UserApiController@editInfo')
        ->name("editInfoRequest");

    Route::put('/setting/nickname', 'Api\UserApiController@editNickname')
        ->name("editNicknameRequest");

    Route::delete('/setting/delete', 'Api\UserApiController@dropUser')
        ->name("dropUserRequest");

    Route::delete('/urls/delete', 'Api\UrlApiController@deleteUserUrl')
        ->name('deleteUserUrl');

    Route::get('/data/total', 'Api\UrlApiController@totalUserUrlData')
        ->name('totalUserUrlData');

    Route::get('/data/url/{urlId}', 'Api\UrlApiController@individualUserUrlAccessData');

    Route::get('/data/link/{urlId}', 'Api\UrlApiController@linkAccessData');
});
Route::get('/test/make-user', "TestController@makeUser");
Route::get('/test/update-user-time', "TestController@updateUserTime");
Route::get('/test/update-url-time', "TestController@updateUrlTime");
Route::get('/test/make-url', "TestController@makeSampleUrl");
Route::get('/test/make-access-url', "TestController@makeAccessUrl");
Route::get('/{path}', 'Web\MainController@originalUrlRedirect');

