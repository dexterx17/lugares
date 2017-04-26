<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'Back@index');
Route::get('/game', 'Back@game');

Route::post('/loader','Back@store');

Route::get('/loader/{google_id}','Back@get_item');
Route::post('/loader/{google_id}','Back@store_item');

Route::post('/visited','Back@visited');


Route::auth();

Route::get('/home', 'HomeController@index');
