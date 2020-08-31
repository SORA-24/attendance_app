<?php

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

// トップページ
Route::get('/', 'MessageController@index')->name('home');
Route::get('/top' , 'MessageController@index');
Route::post('/top/message_add' , 'MessageController@create');
Route::post('/top/stamping' , 'WorkController@stamping');
Route::post('/top/add_comment' , 'WorkController@addcomment');

// 勤怠管理ページ
Route::get('/work/{year}-{month}' , 'UserController@work_index');
// 休日申請ページ
Route::get('/holiday/{year}-{month}' ,'UserController@holiday_index');
Route::post('/holiday/paid_holiday' , 'UserApplicationController@paid_holiday_register');
// 残業申請ページ
Route::get('/overtime' , 'UserApplicationController@overtime_index');
Route::post('/overtime/application' , 'UserApplicationController@overtime_application');

// 仮置きadmin
Route::get('/admin_top' , 'AdminController@index');
// 勤務管理ページ
Route::get('/day/{year}-{month}-{day}' , 'AdminController@day_index');
// ユーザ一覧確認
Route::get('/user' , 'AdminController@user_index');
// 休日申請登録
Route::get('/application' , 'AdminController@application_index');
Route::post('/application/register' , 'Admin\ApplicationController@paid_holidays_register');
// ユーザ個別のページ
Route::get('/admin/user_id{user_id}/{year}-{month}' , 'AdminController@work_index');
Route::get('/admin/record_edit' , 'Admin\RecordEditController@edit_index');
Route::post('/admin/user_edit' , 'Admin\RecordEditController@edit_record');
// ユーザ登録ページ
Route::get('/admin/register' , 'AdminController@user_register_index');

Auth::routes();

Route::prefix('admin')->name('admin::')->group(function() {
    // ログインフォーム
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    // ログイン処理
    Route::post('login', 'Auth\LoginController@login');
    //ログアウト処理
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
});

// admin認証が必要なページ
Route::middleware('auth:admin')->group(function () {
    Route::get('admin', 'AdminController@index');
    Route::get('home', 'Admin\HomeController@index')->name('admin.home');
    
});

Route::get('hello/auth' , 'UserController@getAuth');
Route::post('hello/auth' , 'UserController@postAuth');