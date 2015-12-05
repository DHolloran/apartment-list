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
    mix.sass( 'app.scss', 'resources/assets/css/app.css' );
    mix.browserify( 'app.js' );
    mix.styles( [
        'node_modules/normalize.css/normalize.css',
        'node_modules/dragula/dist/dragula.css',
        'resources/assets/css/app.css'
    ], 'public/css/app.css', './' );

    mix.version( [
        'css/app.css',
        'js/app.js'
    ] );
    mix.browserSync( {
        proxy : 'apartmentlist.dev',
        files : ['!*.css']
    } );
} );
