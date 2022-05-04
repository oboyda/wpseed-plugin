<?php
/**
 * Plugin Name: Tiles Configurator
 * Description: Tiles Configurator Plugin
 * Version: 1.0.0
 * Author: Alexis Boyda
 * Author URI: https://aleapp.com
 * Text Domain: wpboot
 */

define('WPBOOT_NAME', 'Tiles Configurator');
define('WPBOOT_VERSION', '1.0.0');
define('WPBOOT_DIR', dirname(__FILE__));
define('WPBOOT_INDEX', plugins_url('', __FILE__));

add_action('plugins_loaded', function()
{
    require WPBOOT_DIR . '/src/php/setup.php';
    require WPBOOT_DIR . '/vendor/autoload.php';
    
    $deps = new \WPBOOT\Deps([
       'woocommerce/woocommerce.php'
    ]);
    
    if($deps->check())
    {
        require WPBOOT_DIR . '/src/php/utils.php';
        require WPBOOT_DIR . '/src/php/classes/load.php';
        require WPBOOT_DIR . '/src/php/debug.php';
        require WPBOOT_DIR . '/src/php/scripts.php';
        require WPBOOT_DIR . '/src/php/shortcodes.php';
    }
    
}, 100);