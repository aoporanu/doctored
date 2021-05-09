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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .postCss('resources/assets/vendor/animate.css/animate.css', 'public/css')
    .postCss('resources/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css', 'public/css')
    .postCss('resources/assets/vendor/boxicons/css/animations.css', 'public/css')
    .postCss('resources/assets/vendor/boxicons/css/boxicons.css', 'public/css')
    .postCss('resources/assets/vendor/boxicons/css/transformations.css', 'public/css')
    .postCss('resources/assets/vendor/icofont/icofont.min.css', 'public/css');

mix.combine('resources/assets/vendor/*/css', 'all-files.css');
