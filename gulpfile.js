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
    mix.sass('app.scss', 'public/asserts/css/app.css');
    mix.sass('dashboard.scss', 'public/asserts/css/dashboard.css');
    mix.sass('message.scss', 'public/asserts/css/message.css');

    mix.sass('projects/profile.scss', 'public/asserts/css/projects/profile.css');

    mix.sass('products/index.scss', 'public/asserts/css/products/index.css');
    mix.sass('products/profile.scss', 'public/asserts/css/products/profile.css');

    mix.sass('subproducts/profile.scss', 'public/asserts/css/subproducts/profile.css');

    mix.sass('roles/profile.scss', 'public/asserts/css/roles/profile.css');
    mix.sass('roles/index.scss', 'public/asserts/css/roles/index.css');
});
