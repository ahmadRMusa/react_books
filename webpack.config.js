var path = require('path');
var webpack = require('webpack');

module.exports = {
    entry: './js/views/app_view.js',
    output: {
        path: path.join(__dirname, 'dist'),
        filename: 'bundle.js'
    }
}