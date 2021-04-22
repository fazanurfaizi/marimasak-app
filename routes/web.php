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
    Route::resource('users', 'UserController');
    Route::resource('products', 'ProductController');
    Route::resource('product-types', 'ProductTypeController');
    Route::get('/invoices', 'InvoiceController@index')->name('invoices.index');
    Route::get('/invoices/{order}', 'InvoiceController@show')->name('invoices.show');
    Route::put('/invoices/{order}', 'InvoiceController@update')->name('invoices.update');
});
