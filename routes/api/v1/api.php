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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


//Users
Route::prefix('/user')->group(function () {
    Route::post('/login', 'api\v1\LoginController@login');
    Route::post('/register', 'api\v1\LoginController@register');
    Route::middleware('auth:api')->get('/all', 'api\v1\user\UserController@index');
});

//Getters
Route::prefix('/get')->group(function () {
    Route::middleware('auth:api')->get('/movies', 'api\v1\movies\MovieController@index');
    Route::middleware('auth:api')->get('/movie/{id}', 'api\v1\movies\MovieController@show');
    Route::middleware('auth:api')->get('/tvshows', 'api\v1\tvshows\TvshowController@index');
    Route::middleware('auth:api')->get('/tvshow/{id}', 'api\v1\tvshows\TvshowController@show');
    Route::middleware('auth:api')->get('/actors', 'api\v1\actors\ActorController@index');
    Route::middleware('auth:api')->get('/actor/{id}', 'api\v1\actors\ActorController@show');
});


