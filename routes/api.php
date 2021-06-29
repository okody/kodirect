<?php

use Illuminate\Http\Request;
use Illuminate\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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

Route::group(["middleware" => "checkApiPassword", "namespace" => "App\Http\Controllers\Api"], function () {
    Route::GET('posts', "PostController@index");

    Route::group(["prefix" => "/user", "namespace" => "App\Http\Controllers\Api"], function () {
        Route::post("/create" , "UserController@create");
    });
});








Route::get('/', function () {
    return "sorry you are not allowed";
})->name("home");
