var elixir = require('laravel-elixir');
elixir.extend('sourcemaps', false);

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
    mix.sass('app.scss', 'public/assets/css/app.css');
    mix.sass('dashboard.scss', 'public/assets/css/dashboard.css');
    mix.sass('message.scss', 'public/assets/css/message.css');

    mix.sass('projects/profile.scss', 'public/assets/css/projects/profile.css');

    mix.sass('products/index.scss', 'public/assets/css/products/index.css');
    mix.sass('products/profile.scss', 'public/assets/css/products/profile.css');

    mix.sass('subproducts/profile.scss', 'public/assets/css/subproducts/profile.css');

    mix.sass('roles/index.scss', 'public/assets/css/roles/index.css');

    mix.sass('nfs/index.scss', 'public/assets/css/nfs/index.css');

    mix.sass('login.scss', 'public/assets/css/login.css');
});
