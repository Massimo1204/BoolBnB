<?php

use Illuminate\Support\Facades\Auth;
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


Route::get('/users/{user}', 'Auth\EditController@index')
->name('user.edit')
->middleware('auth');


Route::put('/users/{user}', 'Auth\EditController@update')
->name('user.update')
->middleware('auth');

Route::get('/user', 'User\HomeController@index')
->name('user.home')
->middleware('auth');

Route::namespace('Guest')
->prefix('/')
->name("guest.")
->group(function(){
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/{apartment}', 'HomeController@show')->name('show');
    // Route::resource('posts',"PostsController");
});

Route::delete('/picture/{id}', 'User\PicturesDeleteController@destroy')->name("picture.destroy");

Route::resource('/user/apartment',"User\ApartmentController")->middleware('auth');
// Route::delete('/apartment/{id}', 'User\ApartmentController@destroy')->name('user.apartment.destroy');
