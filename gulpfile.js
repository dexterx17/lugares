var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass([
    	'app.scss',
    	'../../../node_modules/font-awesome/scss/font-awesome.scss',
    	'../../../node_modules/sweetalert/dev/sweetalert.scss'
    	]);
});

elixir(function(mix) {
	mix.copy('node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
		'public/js/');
});

elixir(function(mix){
	mix.scripts([
		'../../../node_modules/sweetalert/dist/sweetalert.min.js',
		'../../../node_modules/jquery-sortable/source/js/jquery-sortable-min.js',
		'ui.js',
		'login.js',
		'game.js',
		'core.js',
	],'public/js/app.js');
});