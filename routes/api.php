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
Route::post('/register', 'Auth\RegisterController@store');
Route::post('/login', 'Auth\LoginController@authenticate');

Route::middleware('api')->get('/galleries', 'GalleriesController@index'); 
Route::middleware('api')->post('/galleries', 'GalleriesController@store');
Route::middleware('api')->get('/galleries/{id}', 'GalleriesController@show'); 


