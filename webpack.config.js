
const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');

module.exports = {

    ...defaultConfig,

    // mode: 'production',
    entry: {
        ...defaultConfig.entry,
        admin: path.resolve(process.cwd(), 'src/index-admin.js'),
        front: path.resolve(process.cwd(), 'src/index-front.js')
    }
};
