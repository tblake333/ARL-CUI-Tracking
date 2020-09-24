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

// TODO: Create menu page?
Route::get('/', 'ItemController@index');

/**
 * Item Routes
 */
Route::get('/items', 'ItemController@index');
Route::get('/items/create', 'ItemController@create');
Route::get('/items/search', 'ItemController@search');
Route::post('/items/search', 'ItemController@withQuery');
Route::get('/items/results/{query}', 'ItemController@results');
Route::post('/items', 'ItemController@store');
Route::get('/items/{item}', 'ItemController@show');
Route::get('/items/{item}/edit', 'ItemController@edit');
Route::patch('/items/{item}', 'ItemController@update');

/**
 * User Routes
 */
Route::get('/users', 'UserController@index');
Route::get('/users/create', 'UserController@create');
Route::post('/users', 'UserController@store');
Route::get('/users/{user}', 'UserController@show');
// TODO: Consider editing users

/**
 * Movement Routes
 */
Route::view('/check-out', 'checkout');
Route::post('/check-out/barcode', 'CheckOutController@fromBarcode');
Route::get('/check-out/{item}', 'CheckOutController@show');
Route::post('/check-out/{item}', 'CheckOutController@store');

Route::view('/check-in', 'checkin');
Route::post('/check-in/barcode', 'CheckInController@fromBarcode');
Route::get('/check-in/{item}', 'CheckInController@show');
Route::post('/check-in/{item}', 'CheckInController@store');