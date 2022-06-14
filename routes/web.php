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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/users/{user}', 'Auth\EditController@index')
->name('user.edit')
->middleware('auth');

Route::namespace('Guest')
->prefix('home')
->name("home.")
->group(function(){
    Route::get('/', 'HomeController@index');
    // Route::resource('posts',"PostsController");
});

Route::get('/user/create', 'User\ApartmentController@create')->name('home');

Route::middleware('auth')
    ->namespace('User')
    ->name('user.')
    ->prefix('user')
    ->group( function() {
        Route::get('/messages/create', 'MessageController@create')->name('messages.create');
});
