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

Route::namespace('Api')->prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');
    Route::get('user', 'AuthController@user');
});

Route::namespace('Api\User')->prefix('users/me')->group(function () {
    Route::resource('projects', 'ProjectController');
    Route::resource('projects.environments', 'EnvironmentController');
    Route::resource('projects.endpoints', 'EndpointController');
    Route::resource('endpoints.calls', 'CallController');
});
