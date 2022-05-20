const path = require('path');
const webpack = require('webpack');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');

module.exports = {
  entry: {
      'json-objects-dir': [
          './src/dir/main.ts'
      ],
      'json-objects-item': [
        './src/item/main.ts'
      ]
  },
  plugins: [
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
      'window.jQuery': 'jquery',
      'jquery': 'jquery',
    })
  ],
  output: {
    path: path.resolve(__dirname, '../../../../public/admin-js'),
    filename: '[name].js'
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        loader: 'babel-loader',
        exclude: /node_modules/
      },
      {
        test: /\.ts?$/,
        use: [
                {
                    loader: 'ts-loader',
                    options: {
                        configFile: 'tsconfig.json'
                    }
                }
        ],
        exclude: /node_modules/
      }
    ]
  },
  resolve: {
    alias: {
      '@common': path.resolve(__dirname, '../../../Common/assets'),
    },
    extensions: ['*', '.ts', '.js', '.vue', '.json']
  }
}

if (process.env.NODE_ENV === 'development') {
  module.exports['devServer'] = {
    historyApiFallback: true,
    noInfo: true,
    overlay: true
  };
  module.exports['performance'] = {
    hints: false
  };
  module.exports['devtool'] = '#eval-source-map';
}

if (process.env.NODE_ENV === 'production') {
  module.exports.plugins = (module.exports.plugins || []).concat([
    new webpack.DefinePlugin({
      'process.env': {
        NODE_ENV: '"production"'
      }
    }),
  ]);
  module.exports.optimization = {
    minimizer: [
      new UglifyJsPlugin({
        uglifyOptions: {
          output: {
            comments: false
          }
        }
      })
    ]
  }
}
