<?php

use Illuminate\Http\Request;
use Illuminate\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use Intervention\Image\Facades\Image;


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

Route::get('storage/{filename}', function ($filename) {
    // return storage_path('app/posts/' . $filename);
    return Image::make(storage_path('app/posts/' . $filename))->response();
});

Route::group(["middleware" => "checkApiPassword", "namespace" => "App\Http\Controllers\Api"], function () {

    Route::group(["prefix" => "user"], function () {

        Route::get("/", "UserController@index");
        Route::get("/{userID}", "UserController@get_user");
        Route::post("/create", "UserController@create");
        // Route::delete("/delete/{id}", "UserController@create");
        // Route::put("/update/{id}", "UserController@create");
    });

    Route::group(["prefix" => "tage"], function () {

        Route::get("/", "TageController@index");
        // Route::get("/{tageID}", "TageController@get_tage");
        // Route::post("/create", "TageController@create");
        // Route::delete("/delete/{id}", "TageController@create");
        // Route::put("/update/{id}", "TageController@create");
    });


    Route::group(["prefix" => "post"], function () {

        Route::get("/", "PostController@index");

        Route::get("/{post_id}", "PostController@get_post");
        Route::post("create", "PostController@create")->middleware("checkUserAuth");
        Route::delete("/delete/{post_id}", "PostController@delete");
        Route::put("/update/{post_id}", "PostController@update");


        Route::group(["prefix" => "/{post_id}/comment"], function () {
            Route::get("/", "CommentController@index");
            Route::get("/{comment_id}", "CommentController@get_comment");
            Route::post("/create", "CommentController@create")->middleware("checkUserAuth");

            Route::put("/update/{comment_id}", "CommentController@update");
            Route::delete("/delete/{comment_id}", "CommentController@delete");
        });


        Route::group(["prefix" => "/{post_id}/like"], function () {
            Route::get("/", "LikeController@index");
            Route::get("/{like_id}", "LikeController@get_like");
            Route::post("/create", "LikeController@create")->middleware("checkUserAuth");;

            Route::delete("/delete/{like_id}", "LikeController@delete");
        });



        Route::group(["prefix" => "/{post_id}/view"], function () {
            Route::get("/", "ViewController@index");
            Route::post("/create", "ViewController@create");
        });
    });
});


Route::get('/Api-Authorization', function () {



    return response()->json(

        ['message' => 'you are not authorized to use this api', "success" => false]

    );
})->name("ApiAuthorization");




Route::get('/Role-Authorization', function () {


    return response()->json(

        ['message' => 'you are not authorized to use this data', "success" => false]

    );
})->name("RoleAuthorization");
