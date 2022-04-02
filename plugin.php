<?php
/**
 * Plugin Name: Tiles Configurator
 * Description: Tiles Configurator Plugin
 * Version: 1.0.0
 * Author: Alexis Boyda
 * Author URI: https://aleapp.com
 * Text Domain: tilec
 */

define('TILEC_NAME', 'Tiles Configurator');
define('TILEC_VERSION', '1.0.0');
define('TILEC_DIR', dirname(__FILE__));
define('TILEC_INDEX', plugins_url('', __FILE__));

add_action('plugins_loaded', function()
{
    require TILEC_DIR . '/src/php/setup.php';
    require TILEC_DIR . '/vendor/autoload.php';
    
    $deps = new \TILEC\Deps([
       'woocommerce/woocommerce.php'
    ]);
    
    if($deps->check())
    {
        require TILEC_DIR . '/src/php/utils.php';
        require TILEC_DIR . '/src/php/classes/load.php';
        require TILEC_DIR . '/src/php/debug.php';
        require TILEC_DIR . '/src/php/scripts.php';
        require TILEC_DIR . '/src/php/shortcodes.php';
        require TILEC_DIR . '/src/php/inc/inc.php';
    }
    
}, 100);