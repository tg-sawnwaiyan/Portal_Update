const mix = require('laravel-mix');
require('laravel-mix-bundle-analyzer');
const CompressionPlugin = require('compression-webpack-plugin');
 
// if (!mix.inProduction()) {
//     mix.bundleAnalyzer();
// }
// if (mix.inDevelopment()) {

//     mix.bundleAnalyzer();

// }

if (mix.isWatching()) {

   mix.bundleAnalyzer();

}

module.exports = {
   pluginOptions: {
     compression:{
       brotli: {
         filename: '[path].br[query]',
         algorithm: 'brotliCompress',
         include: /\.(js|css|html|svg|json)(\?.*)?$/i,
         compressionOptions: {
           params: {
             [zlib.constants.BROTLI_PARAM_QUALITY]: 11,
           },
         },
         minRatio: 0.8,
       },
       gzip: {
         filename: '[path].gz[query]',
         algorithm: 'gzip',
         include: /\.(js|css|html|svg|json)(\?.*)?$/i,
         minRatio: 0.8,
       }
     }
   }
 }

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
 mix.webpackConfig({
   output: {
       chunkFilename: "js/chunk/[name].js",
   }
})


mix.js('resources/js/app.js', 'public/js')
   .extract(['vue','bootstrap'])
   .sass('resources/sass/app.scss', 'public/css');
// mix.css('resources/css/mystyle.css', 'public/css'); //V



// mix.js('resources/js/myJs.js', 'public/js');



// mix.webpackConfig({

//    resolve: {

//       alias: {

//          'vue$': 'vue/dist/vue.runtime.common.js'

//       }

//    }

//    });
