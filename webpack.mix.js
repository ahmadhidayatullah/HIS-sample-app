const mix = require('laravel-mix');
const path = require('path');

mix.js('resources/js/app.js', 'public/js')
   .vue() // This enables Vue 3 support
   .postCss('resources/css/app.css', 'public/css', [
       // PostCSS plugins...
   ])
   .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve(__dirname, 'resources/js'), // This adds the @ alias
            },
            extensions: ['.*', '.wasm', '.mjs', '.js', '.jsx', '.json', '.vue', '.*']
        },
    });

mix.copy('node_modules/@mdi/font/fonts/', 'dist/fonts/')
