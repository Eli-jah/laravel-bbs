<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('test', function () {
    $qq = base64_decode('MzI1Njg0MDkzNA==');
    $wechat = base64_decode('MTc2MjMyMzk4ODc=');
    $email = base64_decode('c2Vhb255QG91dGxvb2suY29t');
    echo '<br>';
    echo $qq;
    echo '<br>';
    echo $wechat;
    echo '<br>';
    echo $email;
    echo '<br>';
    echo bin2hex('KEY');
    echo '<br>';
    echo hex2bin('56414c5545');
    echo '<br>';
    echo strlen('{"key1":"value1","key2":"value2"}');
    echo '<br>';
    echo strlen(bin2hex('{"key1":"value1","key2":"value2"}'));
    echo '<br>';
    echo bin2hex('{"key1":"value1","key2":"value2"}');
});

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', 'PagesController@root')->name('root');

Auth::routes([
    'register' => true,
    'reset' => true,
    'verify' => true, // Email Verification
]);

/* Email Verification */
// Route::emailVerification();

/*
// 用户身份验证相关的路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// 用户注册相关路由
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// 密码重置相关路由
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email 认证相关路由
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
*/

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('users', 'UsersController', ['only' => ['show', 'edit', 'update']]);

Route::resource('topics', 'TopicsController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
