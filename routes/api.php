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

Route::group(['prefix' => '/', 'namespace' => 'Recipe', 'middleware' => 'auth:api'], function() {
    Route::apiResource('recipe', 'RecipeController');
    Route::prefix('recipe-comment')->group(function () {
        Route::post('/', 'RecipeCommentController@store');
        Route::get('/{id}', 'RecipeCommentController@show');
        Route::put('/{id}', 'RecipeCommentController@update');
        Route::delete('/{id}', 'RecipeCommentController@destroy');
    });
    Route::post('/recipe-like/{id}', 'RecipeLikeController');
});
