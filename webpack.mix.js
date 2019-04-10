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
mix.js('resources/js/app.js', 'public/js').version()
   .js('resources/js/Maqueta3.js',"public/js/Maqueta3.js").version()
   .sass('resources/sass/bootstrap.scss', 'public/css/bootstrap.css').version()
   .sass('resources/sass/Maqueta1.scss', 'public/css/Maqueta1.css').version()
   .copy('resources/css/Maqueta2.css','public/css/Maqueta2.css') .version();  
/*mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css/app.css');*/
