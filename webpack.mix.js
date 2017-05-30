const { mix } = require('laravel-mix');

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
if (process.env.NODE_ENV == 'production') {
    //mix.disableNotifications();
}

/*mix.webpackConfig({
    devtool: 'cheap-source-map'
});*/

 
mix.react('resources/assets/js/app.js', 'public/js')
//.react('resources/assets/js/react_main.jsx', 'public/js') 
   .sass('resources/assets/sass/app.scss', 'public/css') ;
  // .react('resources/assets/js/react_main.js', 'public/js');
  //.version(['css/app.css', 'js/app.js']);
