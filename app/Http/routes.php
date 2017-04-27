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

Route::get('/privacidad', function(){
	return view('privacidad');
});

Route::get('/terminos-uso', function(){
	return view('terminos_uso');
});


Route::auth();

Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

Route::group(['middleware'=>'auth'],function(){
	Route::get('/game', [
		'uses'=>'Back@game',
		'as'=>'game'
	]);
	Route::get('/game/{categoria}/{provincia}', [
		'uses'=>'Back@game_provincia',
		'as'=>'game.provincia'
	]);
	Route::post('/load',[
		'uses'=>'Back@store',
		'as'=>'loader']
	);

	Route::get('/loader/{google_id}','Back@get_item');
	Route::post('/loader/{google_id}','Back@store_item');

	Route::post('/visited','Back@visited');

		/* rutas CATEGORIAS */
	Route::resource('categorias','Categorias',['except'=>['destroy','show']]);
	Route::post('categorias/{actividad_id}',[
		'uses' =>'Categorias@update',
		'as'=>'categorias.update'
	]);
	Route::get('categorias/{id}/destroy',[
		'uses'=>'Categorias@destroy',
		'as' =>'categorias.destroy'
	]);
		Route::post('categoris/reordenar',[
		'uses'=>'Categorias@reordenar',
		'as'=>'categorias.reordenar']
	);

});

