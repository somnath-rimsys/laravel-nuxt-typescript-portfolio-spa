<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', 'App\Http\Controllers\AuthController@register');
Route::post('/login', 'App\Http\Controllers\AuthController@login');

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('/logout', 'App\Http\Controllers\AuthController@logout');
    Route::get('/logout-all', 'App\Http\Controllers\AuthController@logoutAll');
   
    Route::get('/user', 'App\Http\Controllers\UserController@getUser');

    Route::get('/user/getProfileImage', 'App\Http\Controllers\UserController@getProfileImage');
    Route::post('/user/updateBasicDetails', 'App\Http\Controllers\UserController@updateBasicDetails');

    Route::get('/user/getExperiences', 'App\Http\Controllers\UserController@getExperiences');
    Route::post('/user/addExperience', 'App\Http\Controllers\UserController@addExperience');
    Route::post('/user/updateExperience', 'App\Http\Controllers\UserController@updateExperience');
    Route::post('/user/deleteExperience', 'App\Http\Controllers\UserController@deleteExperience');
});