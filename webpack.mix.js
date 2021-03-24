const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss')
const path = require('path')

mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js')
        }
    }
})

mix.js('resources/js/app.js', 'public/js/')
    .vue({
        version: 2,
        extractStyles: true
    })
    .sass('resources/sass/marimasak.scss', 'public/css/')
    .options({
        postCss: [tailwindcss('./tailwind.config.js')]
    })

if(!mix.inProduction()) {
    mix.webpackConfig({
        devtool: 'source-map'
    }).sourceMaps()
} else {
    mix.version()
}
