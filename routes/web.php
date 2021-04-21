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
    Route::resource('product-types', 'ProductTypeController');
    Route::get('/invoices', 'InvoiceController@index')->name('invoices.index');
    Route::get('/invoices/{order}', 'InvoiceController@show')->name('invoices.show');
    Route::put('/invoices/{order}', 'InvoiceController@update')->name('invoices.update');
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
