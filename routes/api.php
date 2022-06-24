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

Route::get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:api')->get('/messages', 'Api\MessageController@index');
Route::get('/apartments', 'Api\ApartmentController@index');
Route::get('/apartment/{id}','Api\ApartmentController@show');
Route::get('/apartment/pictures/{id}','Api\PicturesController@show');

Route::get('/services','Api\ServicesController@index');
Route::get('/apartment/service/{apartment}','Api\ApartmentServiceController@show');
Route::get('/apartment','Api\ApartmentController@search');
Route::get('/apartment/host/{id}','Api\UserController@show');
Route::get('/apartments/filteredsearch', 'Api\ApartmentController@filteredSearch');
Route::get('/apartments/{id}', 'Api\ApartmentController@statsApartment');



Route::namespace('Api')->group( function () {
    Route::post('/message', 'MessageController@store');
    Route::get('/apartment/messages/{user}', 'MessageController@getApartmentMessages');
    Route::get('/sponsored/apartments', 'ApartmentController@getSponsored');
});

