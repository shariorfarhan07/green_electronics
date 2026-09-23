const mix = require('laravel-mix');
const path = require('path');

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

// One bundle: every page in the app (storefront, auth and admin) is an Inertia
// page rendered by this entry point. The old resources/js/app.js entry was the
// jQuery/Bootstrap-plugin + vanilla-DOM-enhancement bundle for the Blade views
// that no longer exist — Bootstrap's *SCSS* is still imported by app.scss for
// its grid and form classes.
mix.react('resources/js/inertia.jsx', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

// webpack 4's bundled acorn parser (this project predates webpack 5) can't parse
// the ES2020 syntax (?? etc.) that @inertiajs/{react,core} ship pre-built in their
// dist — node_modules is excluded from babel-loader by default, so it needs an
// explicit override to run through Babel too instead of being left as raw JS.
mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.jsx?$/,
                include: /node_modules[\\/]@inertiajs/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: [['@babel/preset-env', { targets: { esmodules: false } }]],
                    },
                },
            },
        ],
    },
    resolve: {
        alias: {
            // Webpack 4's default mainFields (browser/module/main) picks axios's
            // ESM `index.js` over its CJS build. @inertiajs/core's pre-bundled
            // dist does a raw `require("axios")` with its own esbuild-style
            // interop helper that expects a real CJS module — against the ESM
            // build that produced `(0, M.default) is not a function`, since the
            // helper's __esModule check didn't get the shape it expected. Forcing
            // the same CJS build Node itself resolves to (verified to expose a
            // working `.default`) sidesteps the mismatch project-wide.
            axios$: path.resolve(__dirname, 'node_modules/axios/dist/node/axios.cjs'),
        },
    },
});
