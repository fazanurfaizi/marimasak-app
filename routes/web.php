<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::group(['middleware' => 'auth', 'namespace' => 'Admin'], function() {
    Route::get('/', 'DashboardController@index');
    Route::resource('products', 'ProductController');
    // Route::get('/input-product', function () {
    //     return view('/product/input_product');
    // });
    // Route::get('/category', function () {
    //     return view('/category/category');
    // });
    // Route::get('/edit-category', function () {
    //     return view('/category/edit_category');
    // });
    // Route::get('/input-category', function () {
    //     return view('/category/input_category');
    // });
});
