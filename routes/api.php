<?php

use Illuminate\Http\Request;
use App\Order;
use App\Product;

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

Route::post('customers', 'CustomerController@store')->middleware('auth:api');
Route::get('customers', 'CustomerController@index')->middleware('auth:api');
Route::get('customers/{customer}', 'CustomerController@show')->middleware('auth:api');

Route::get('products', 'ProductController@index')->middleware('auth:api');
Route::post('products', 'ProductController@store')->middleware('auth:api');
Route::patch('products/{product}', 'ProductController@update')->middleware('auth:api');

Route::post('addresses', 'AddressController@store')->middleware('auth:api');
Route::patch('addresses/default' , 'AddressController@setDefault')->middleware('auth:api');
Route::patch('addresses/{address}' , 'AddressController@update')->middleware('auth:api');


Route::get('orders', 'OrderController@index')->middleware('auth:api');
Route::get('orders/{order}', 'OrderController@show')->middleware('auth:api');
Route::post('order', 'OrderController@store')->middleware('auth:api');
Route::post('order/{order}/items' , 'OrderItemController@store')->middleware('auth:api');
Route::patch('order/{order}/status' , 'OrderController@status')->middleware('auth:api');

Route::post('login', 'PassportController@login');
Route::patch('orders/{order}', 'OrderController@update')->middleware('auth:api');

