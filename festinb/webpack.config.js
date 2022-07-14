const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.scss) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')
    // JS Entry
    .addEntry('homepage_slider_js', './assets/js/components/homepage_slider.js')
    .addEntry('login_js', './assets/js/pages/_login.js')


    //SCSS Entry
    .addStyleEntry('homepage_slider_scss', './assets/scss/components/_homepage_slider.scss')
    .addStyleEntry('homepage_search_bar_scss', './assets/scss/components/_homepage_search_bar.scss')
    .addStyleEntry('filters_scss', './assets/scss/components/_filters.scss')
    .addStyleEntry('login_scss', './assets/scss/pages/_login.scss')
    .addStyleEntry('register_scss', './assets/scss/pages/_register.scss')
    .addStyleEntry('festivals_scss', './assets/scss/pages/_festivals.scss')
    .addStyleEntry('festival_card_scss', './assets/scss/components/_festival_card.scss')
    .addStyleEntry('festival_scss', './assets/scss/pages/_festival.scss')
    .addStyleEntry('forgot_password_scss', './assets/scss/pages/_forgot_password.scss')
    .addStyleEntry('client_area_scss', './assets/scss/layouts/_client_area.scss')
    .addStyleEntry('footer_scss', './assets/scss/layouts/_footer.scss')
    .addStyleEntry('cart_front_scss', './assets/scss/layouts/_cart_front.scss')
    .addStyleEntry('partners_front_scss', './assets/scss/layouts/_partners_front.scss')




    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    .enableStimulusBridge('./assets/controllers.json')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use React
    //.enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
