var elixir = require( 'laravel-elixir' );
require( 'laravel-elixir-postcss' );

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

elixir( function( mix ) {
	mix.sass( 'app.scss' );
	mix.browserify( 'app.js' );
	mix.postcss( 'app.css', {
    srcDir  : 'public/css',
    plugins :[
      require( 'postcss-import' ),
      require( 'css-mqpacker' ),
    ]
  } );
	mix.version( [ 'css/app.css', 'js/app.js' ] );
	mix.browserSync( {
		proxy : 'test.dev'
	} );
} );
