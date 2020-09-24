<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\Item as ItemResource;
use App\Item;
use App\User;

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

Route::get('/user/{badge_number}', function($badge_number) {
    return new UserResource(User::find($badge_number));
});

Route::get('/item/{item_id}', function($item_id) {
    return new ItemResource(Item::find($item_id));
});
