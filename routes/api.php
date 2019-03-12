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

Route::namespace('Api')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', 'AuthController@register')->name('auth.register');
        Route::post('login', 'AuthController@login')->name('auth.login');
        Route::get('logout', 'AuthController@logout')->name('auth.logout');
        Route::get('user', 'AuthController@user')->name('auth.user');
    });
    Route::resource('users', 'UserController');
});

Route::namespace('Api\User')->prefix('users/me')->group(function () {
    Route::resource('projects', 'ProjectController');
    Route::resource('projects.environments', 'EnvironmentController');
    Route::resource('projects.endpoints', 'EndpointController');
    Route::resource('endpoints.calls', 'CallController');
});
