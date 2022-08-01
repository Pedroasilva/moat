<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Default Route Create by Laravel
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Default Route Create by Laravel


//
// **  ROTAS sem PROTEÇÃO JWT VÃO AQUI  **
//
Route::group([
    'namespace' => 'Api',
    'middleware' => 'api',
    'prefix' => '',
], function($router) {
    Route::post('login', 'AuthController@login')->name('api.auth.login');
    Route::post('logout', 'AuthController@logout')->name('api.auth.logout');
    Route::post('signup', 'UserController@signup')->name('api.auth.signup');
    Route::post('password-reset/request', 'AuthController@resetPassword')->name('api.auth.password.reset');
    Route::post('password-reset/update', 'AuthController@sendResetPassword')->name('api.auth.password.update');
});

// //
// // **  ROTAS COM PROTEÇÃO JWT ** /players
// //
Route::group([
    'namespace' => 'Api',
    'middleware' => 'jwt:api',
    'prefix' => 'players',
], function($router) {
    Route::post('accept-terms', 'AuthController@acceptTerms')->name('api.players.acceptTerms');
    Route::get('send-verification-email', 'AuthController@sendVerificationEmail')->name('api.players.profile.verification');

    Route::put('profile/edit', 'UserController@edit')->name('api.players.profile.update');
    Route::get('profile', 'UserController@userInfo')->name('api.players.profile.get');

    Route::post('company/add', 'UserController@addCompany')->name('api.players.company.create');
    Route::put('company/edit', 'UserController@editCompany')->name('api.players.company.update');

    Route::get('company', 'UserController@myCompany')->name('api.players.company');
    Route::post('company/edit', 'UserController@editCompany')->name('api.players.company.update');
});

//
// **  ROTAS COM PROTEÇÃO JWT ** /users
//
Route::group([
    'namespace' => 'Api',
    'middleware' => 'jwt:api',
    'prefix' => 'users',
], function($router) {
    Route::get('/', 'UserController@companyUsers')->name('api.players.company.user.list');
    Route::post('/', 'UserController@addCompanyUser')->name('api.players.company.user.add');
    Route::put('/edit/{id}', 'UserController@editCompanyUser')->name('api.players.company.user.edit');
    Route::delete('/remove/{id}', 'UserController@removeCompanyUser')->name('api.players.company.user.remove');
});