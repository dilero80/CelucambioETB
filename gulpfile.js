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
  mix.browserSync({
    proxy: 'etbtelocambio.dev'
  });
  mix.sass('app.scss');
  mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap', 'public/fonts/bootstrap');
  mix.scripts([
    '../../../node_modules/jquery/dist/jquery.min.js',
    '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
    '../../../node_modules/moment/min/moment.min.js',
    '../../../node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
    '../../../node_modules/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js',
    '../../../node_modules/numeral/min/numeral.min.js',
    '../../../node_modules/humane-js/humane.min.js',
    '../../../node_modules/picturefill/dist/picturefill.min.js',
    'lib/inputTypeNumberPolyfill.js',
    'lib/jquery-ui.min.js',
    'lib/jquery-ui-slider-pips.min.js',
    'utils.js',
    'steps.js',
    'auth.js',
    'orders.js'
  ]);
});
