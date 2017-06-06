// gulpfile.js 
var elixir = require('laravel-elixir');
var path = require('path'); 
 
require('laravel-elixir-eslint');
 
elixir(function(mix) {
	//run php browser-kit based tests
	mix.phpUnit([] , path.normalize('vendor/bin/phpunit') + ' --verbose');
	//mix.eslint([
	//'public/js/**/*.js',
	//'resources/assets/js/**/*.js'
	//]);
});
