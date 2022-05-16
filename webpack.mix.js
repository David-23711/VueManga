const mix = require("laravel-mix");
var VuetifyLoaderPlugin = require("vuetify-loader/lib/plugin");
var CaseSensitivePathsPlugin = require("case-sensitive-paths-webpack-plugin");
mix.browserSync({
    proxy: "http://127.0.0.1:8000/user",
});

var webpackConfig = {
    plugins: [new VuetifyLoaderPlugin(), new CaseSensitivePathsPlugin()],
};
mix.webpackConfig(webpackConfig);

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

mix.js("resources/js/app.js", "public/js")
    .vue()
    .sass("resources/sass/app.scss", "public/css")
    .version();
