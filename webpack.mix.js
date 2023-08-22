const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js( 'resources/js/app.js', 'public/js' )
//FUMI js 追加 カレールー計算用 8h_alice.js
.js( 'resources/js/currypateculs.js', 'public/js' )
.js( 'resources/js/fumi0214.js', 'public/js' )
.js( 'resources/js/fumi0307.js', 'public/js' )
.js( 'resources/js/admin_consumed.js', 'public/js' )
.js( 'resources/js/8h_alice.js', 'public/js' )
.js( 'resources/js/courses_matin.js', 'public/js' )
.js( 'resources/js/fumi0619_chklist.js', 'public/js' )
.autoload( {
    "jquery": [ '$', 'window.jQuery' ],
} )
.sass('resources/sass/app.scss', 'public/css')
.sourceMaps();
