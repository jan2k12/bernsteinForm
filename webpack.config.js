var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')

    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
     .addEntry('js/app', './assets/js/app.js')
     .addStyleEntry('css/main', './assets/css/main.scss')
     .addStyleEntry('css/form', './assets/css/form.scss')
     .addEntry('img/icons8-ok-48.png','./assets/img/icons8-ok-48.png')
     .addEntry('img/icons8-stornieren-48.png','./assets/img/icons8-stornieren-48.png')

    // uncomment if you use Sass/SCSS files
    .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    // .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
