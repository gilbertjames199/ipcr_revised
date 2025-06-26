const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |.vue()
 */
mix.js('resources/js/app.js', 'public/js')
    .extract()
    .vue(3)
    .sass('resources/sass/app.scss', 'public/css')
    .alias({ '@': 'resources/js' })
    .options({
        hmrOptions: {
            host: 'localhost',
            port: 8088
        }
    })
    .version();

<<<<<<< HEAD
mix.disableSuccessNotifications();

=======
mix.disableNotifications();
>>>>>>> e7c848f94d8998be63ebf1f546b3f648bea40814
