<?php

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
    return view('welcome');
});

Route::get('/getdata', "StoresController@getData");
Route::get('/getToken', "StoresController@getToken");
Route::post('/store/signup', "StoresController@signup");
Route::post('/store/login', "StoresController@login");
Route::post('/store/logout', "StoresController@logout");
Route::post('/store/{id}/update', "StoresController@update");
Route::post('/store/change_password', "StoresController@changePassword");

Route::post('/store/index/{id}', "StoresController@getAll");

Route::post('/store/{id}/add_item', "ItemsController@add_item");
Route::post('/store/{id}/get_items', "ItemsController@get_items");
Route::post('/store/get_item/{id}', "ItemsController@get_item");
Route::post('/store/update_item/{id}', "ItemsController@update_item");
Route::post('/store/delete_item/{id}', "ItemsController@delete_item");

Route::post('/store/{id}/store_item_price', "ItemPriceController@store_item_price");
Route::post('/store/{id}/get_item_price', "ItemPriceController@get_item_price");

Route::get('/store/image', "StoresController@isValidateImage");

Route::post('/store/sending_message', "StoresController@sending_message");

Route::post('/store/get_confirm_code/{phone_number}', "CodesController@get_confirm_code");
Route::post('/store/confirm_code/{phone_number}/{code}', "CodesController@confirm_code");
