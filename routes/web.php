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

Route::get('/', function () {
    return view('dashboard');
});
Route::get('/product', function () {
    return view('/product/product');
});
Route::get('/edit-product', function () {
    return view('/product/edit_product');
});
Route::get('/input-product', function () {
    return view('/product/input_product');
});
Route::get('/category', function () {
    return view('/category/category');
});
Route::get('/edit-category', function () {
    return view('/category/edit_category');
});
Route::get('/input-category', function () {
    return view('/category/input_category');
});
Route::get('/user', function () {
    return view('/user/user');
});
Route::get('/edit-user', function () {
    return view('/user/edit_user');
});
Route::get('/input-user', function () {
    return view('/user/input_user');
});
Route::get('/role', function () {
    return view('/roleuser/roleuser');
});
Route::get('/edit-role', function () {
    return view('/roleuser/edit_role');
});
Route::get('/input-role', function () {
    return view('/roleuser/input_role');
});
Route::get('/permission', function () {
    return view('/permission/permission');
});
Route::get('/edit-permission', function () {
    return view('/permission/edit_permission');
});
Route::get('/input-permission', function () {
    return view('/permission/input_permission');
});