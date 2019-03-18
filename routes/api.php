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
    Route::resource('users', 'UserController')->only(['index', 'store']);
    Route::resource('users.projects', 'ProjectController')->only(['index', 'show']);

    Route::prefix('auth')->group(function () {
        Route::post('register', 'AuthController@register')->name('auth.register');
        Route::post('login', 'AuthController@login')->name('auth.login');
        Route::get('logout', 'AuthController@logout')->name('auth.logout')->middleware('auth:api');
        Route::get('user', 'AuthController@user')->name('auth.user')->middleware('auth:api');
    });

    Route::middleware('auth:api')->group(function () {
        Route::namespace('Admin')->prefix('admin')->group(function () {
            Route::resource('users', 'UserController');
        });

        Route::namespace('User')->prefix('users/me')->group(function () {
            Route::resource('projects', 'ProjectController');
            Route::resource('projects.environments', 'EnvironmentController');
            Route::resource('projects.endpoints', 'EndpointController');
            Route::resource('endpoints.calls', 'CallController');
        });
    });
});
