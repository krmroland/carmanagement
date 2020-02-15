const path = require('path');
const mix = require('laravel-mix');

require('laravel-mix-tailwind');
require('laravel-mix-purgecss');

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

mix
  .webpackConfig({
    resolve: {
      alias: {
        '@': path.resolve(__dirname, 'resources/ui'),
      },
    },
  })
  .react('resources/ui/main.js', 'public/js/app.js')
  .postCss('resources/css/app.css', 'public/css')
  .tailwind('./tailwind.config.js')
  .extract();

if (mix.inProduction()) {
  mix.version().purgeCss();
}
