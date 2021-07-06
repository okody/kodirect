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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(["middleware" => "checkApiPassword", "namespace" => "App\Http\Controllers\Api"], function () {

    Route::group(["prefix" => "user"], function () {

        Route::get("/", "UserController@index");
        Route::get("/{userID}", "UserController@get_user");
        Route::post("create", "UserController@create");
        Route::delete("/delete/{id}", "UserController@create");
        Route::put("/update/{id}", "UserController@create");
    });


    Route::group(["prefix" => "post"], function () {

        Route::get("/", "PostController@index");
        Route::get("/tage/{tage}", "PostController@getByTage");




        // Route::get("/{id}", "PostController@get_post");
        Route::post("create", "PostController@create");
        // Route::delete("/delete/{id}", "PostController@create");
        // Route::put("/update/{id}", "PostController@create");

        Route::group(["prefix" => "/{id}/comment"], function () {
            Route::post("/create", "CommentController@create");
        });


        Route::group(["prefix" => "/{id}/like"], function () {
            Route::post("/create", "LikeController@create");
        });

    });
});








Route::get('/Api-Authorization', function () {
    return ['message' => 'you are not authorized to use this api', "status" => false];
})->name("ApiAuthorization");

Route::get('/Role-Authorization', function () {
    return ['message' => 'you are not authorized to use this data', "status" => false];
})->name("RoleAuthorization");
