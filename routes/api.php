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

Route::get('orders', 'OrderController@index')->middleware('auth:api');
Route::get('customers', 'CustomerController@index')->middleware('auth:api');
Route::get('customers/{customer}', 'CustomerController@show');

Route::get('products', 'ProductController@index')->middleware('auth:api');
Route::post('address', 'AddressController@store')->middleware('auth:api');

Route::post('login', 'PassportController@login');

Route::post('order', 'OrderController@store')->middleware('auth:api');

Route::post('customers', 'CustomerController@store')->middleware('auth:api');
Route::post('order', 'OrderController@store');
Route::post('order/{order}/items' , 'OrderItemController@store');
