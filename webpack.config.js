
const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');

module.exports = {

    ...defaultConfig,

    // mode: 'production',
    entry: {
        ...defaultConfig.entry,
        style: path.resolve(process.cwd(), 'src/scss', 'index.scss')
    }
};
