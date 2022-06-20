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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:api')->get('/messages', 'Api\MessageController@index');
Route::get('/apartments', 'Api\ApartmentController@index');
Route::get('/apartment/{id}','Api\ApartmentController@show');

Route::namespace('Api')->group( function () {
    Route::post('/message', 'MessageController@store');
    Route::get('/apartment/messages/{apartment}', 'MessageController@getApartmentMessages');
});

