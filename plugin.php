<?php
/**
 * Plugin Name: WPPB
 * Description: WPPB Plugin
 * Version: 1.0
 * Author: Alexis Boyda
 * Author URI: https://aleapp.com
 * Text Domain: wppb
 */

define('WPPB_NAME', 'WPPB Plugin');
define('WPPB_VERSION', '1.0');
define('WPPB_DIR', dirname(__FILE__));
define('WPPB_INDEX', plugins_url('', __FILE__));

add_action('plugins_loaded', function()
{
    require WPPB_DIR . '/src/php/setup.php';
    require WPPB_DIR . '/vendor/autoload.php';
    
    $deps = new \WPPB\Deps([
       'woocommerce/woocommerce.php'
    ]);
    
    if($deps->check())
    {
        require WPPB_DIR . '/src/php/utils.php';
        require WPPB_DIR . '/src/php/classes/load.php';
        require WPPB_DIR . '/src/php/debug.php';
        require WPPB_DIR . '/src/php/scripts.php';
        require WPPB_DIR . '/src/php/shortcodes.php';
    }
    
}, 100);