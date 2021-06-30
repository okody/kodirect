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
    Route::get('posts', "PostController@index");

    Route::group(["prefix" => "user"], function () {


        // Route::get("/{id}" , "UserController@get_user");
        Route::post("create" , "UserController@create");
        
        // Route::delete("/delete" , "UserController@create");
    });
});








Route::get('/', function () {
    return ['message' =>'you are not authrized to access this api' , "status" => false];
})->name("home");
