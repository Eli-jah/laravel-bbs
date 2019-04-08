<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('test', function () {
    $password = \Illuminate\Support\Facades\Hash::check('secret', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm');
    $password = \Illuminate\Support\Facades\Hash::make('123456');
    dd($password);
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
    echo '<br>';
    echo str_pad(strtoupper(dechex(60403)), 8, '0', STR_PAD_LEFT);
    echo '<br>';
    echo hexdec(10);
    echo '<br>';
    // echo hexdec(ltrim('000000', '0'));
    // echo ltrim('000000', '0');
    // echo hexdec('');
    echo hex2bin('23235F2A2A');
    echo '<br>';
    echo dechex('20201');
    echo '<br>';
    echo hex2bin('50');
    echo '<br>';
    echo bin2hex('"22222222222222222222222222222222"');
    echo '<br>';
    echo bin2hex('22222222222222222222222222222222');
    echo '<br>';
    echo decbin(hexdec('0x50'));
    echo '<br>';
    echo hex2bin('3039');
    echo '<br>';
    echo hexdec(3039);
    // echo hex2bin('505050505050');
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

Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');
// Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show')->middleware('topics.link');

# For uploading image
Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');

Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);
