const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
      require('tailwindcss'),
   ])
   .copy('node_modules/alpinejs/dist/cdn.min.js', 'public/js/alpine.js')
   .version();
