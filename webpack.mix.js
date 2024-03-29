class WebPackConf {
    webpackConfig(webpackConfig){
        webpackConfig.resolve.alias = {
            "vue$": "vue/dist/vue.esm.js",
            "@": __dirname + "/resources",
            "@js": __dirname + "/resources/js",
            "@views": __dirname + "/resources/views",
            "@lang": __dirname + "/resources/lang"
        };
    }
};

require('dotenv').config();
const mix = require("laravel-mix");
mix.extend("customConfig", new WebPackConf);
mix.customConfig();
/*
 |--------------------------------------------------------------------------
 | Mix Asset User
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.js("resources/js/app.js", "public/js")
   .sass("resources/sass/app.scss", "public/css");