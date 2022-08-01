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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/google-activate', 'Api\GoogleController@activate')->name('api.google.activate');

// Auth Routes
Route::get('auth/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('auth/login', 'Auth\LoginController@login');
Route::get('auth/logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

//
// **  ROTAS COM PROTEÇÃO JWT ** /admin
//
Route::group([
    'namespace' => 'Admin',
    'middleware' => 'admin',
    'prefix' => 'admin',
], function($router) {
    Route::get('/', 'DashboardController@index')->name('admin.home');
    
    // Establishments
    Route::get('/establishments', 'EstablishmentController@index')->name('admin.establishments');
    Route::get('/establishments/{establishmentId}', 'EstablishmentController@view')->name('admin.establishments.view');
    Route::get('/establishments/{establishmentId}/edit', 'EstablishmentController@edit')->name('admin.establishments.edit');
    Route::post('/establishments/{establishmentId}/update', 'EstablishmentController@update')->name('admin.establishments.update');
    Route::get('/establishments-create', 'EstablishmentController@new')->name('admin.establishments.create');
    Route::post('/establishments-create', 'EstablishmentController@create')->name('admin.establishments.create.post');

    Route::get('/users', 'UsersController@index')->name('admin.users');
    Route::get('/users/{userId}', 'UsersController@edit')->name('admin.users.view');
    Route::get('/users/{userId}/block', 'UsersController@block')->name('admin.users.block');
    Route::get('/users/{userId}/unblock', 'UsersController@unblock')->name('admin.users.unblock');
});