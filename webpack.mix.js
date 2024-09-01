const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/messages.js', 'public/js')
    .vue()
    .extract(['vue'])
    .postCss('resources/css/app.css', 'public/css',[
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env']
                        }
                    }
                }
            ]
        }
    });

// // Optional: Versioning and other options
// if (mix.inProduction()) {
//     mix.version();
// }
