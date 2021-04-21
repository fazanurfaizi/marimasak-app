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

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function() {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

    Route::middleware(['auth:api'])->group(function () {
        Route::get('me', 'AuthController@user');
        Route::get('logout', 'AuthController@logout');
    });
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::group(['namespace' => 'User'], function() {
        Route::get('/user', 'UserController@index');
        Route::get('/user/{id}', 'UserController@show');
        Route::post('/user-follow', 'UserController@follow');
        Route::get('/my-recipes', 'UserController@myRecipes');
    });

    Route::group(['namespace' => 'Recipe'], function() {
        Route::apiResource('recipes', 'RecipeController');
        Route::group(['prefix' => 'recipe-comment'], function () {
            Route::post('/', 'RecipeCommentController@store');
            Route::get('/{id}', 'RecipeCommentController@show');
            Route::put('/{id}', 'RecipeCommentController@update');
            Route::delete('/{id}', 'RecipeCommentController@destroy');
        });
        Route::post('/recipe-like/{id}', 'RecipeLikeController');
    });

    Route::group(['namespace' => 'Product'], function() {
        Route::get('product-types', 'ProductTypeController');
        Route::get('/products', 'ProductController@index');
        Route::get('/products/{id}', 'ProductController@show');

        Route::group(['prefix' => 'product-comment'], function() {
            Route::post('/', 'ProductCommentController@store');
            Route::post('/{id}', 'ProductCommentController@show');
            Route::post('/{id}', 'ProductCommentController@update');
            Route::post('/{id}', 'ProductCommentController@destroy');
        });

        Route::post('product-like/{id}', 'ProductLikeController');
    });

    Route::group(['namespace' => 'Chat'], function() {
        Route::prefix('chatrooms')->group(function () {
            Route::get('/', 'ChatroomController@index');
            Route::get('/{id}', 'ChatroomController@show');
            Route::post('/{id}/setreading', 'ChatroomController@setReading');
            Route::post('/{id}/typing', 'ChatroomController@typing');
        });

        Route::prefix('messages')->group(function () {
            Route::get('/', 'MessageController@index');
            Route::post('/', 'MessageController@store');
            Route::post('/{id}/upload', 'MessageController@upload');
            Route::delete('/{id}', 'MessageController@destroy');
        });
    });
});
