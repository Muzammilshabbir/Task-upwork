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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post("/signup","UserController@signUp");

Route::get("/send-email/{id}","UserController@sendEmail");

Route::get("/login-user/{id}","UserController@loginUser");

Route::post("/update-profile/{id}","UserController@profileUpdate");