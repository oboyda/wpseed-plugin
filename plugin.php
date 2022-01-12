<?php
/**
 * Plugin Name: WPPB Plugin
 * Description: Bootstrap plugin that makes it easier to start a new plugin development
 * Version: 1.4.0
 * Author: Alexis Boyda
 * Author URI: https://aleapp.com
 * Text Domain: wppb
 */

define('WPPB_NAME', 'WPPB Plugin');
define('WPPB_VERSION', '1.4.0');
define('WPPB_DIR', dirname(__FILE__));
define('WPPB_INDEX', plugins_url('', __FILE__));

add_action('plugins_loaded', function()
{
    require WPPB_DIR . '/src/setup.php';
    require WPPB_DIR . '/vendor/autoload.php';
    
    $deps = new \WPPB\Deps([
//        'woocommerce/woocommerce.php'
    ]);
    
    if($deps->check())
    {
        require WPPB_DIR . '/src/utils.php';
        require WPPB_DIR . '/src/classes/load.php';
        require WPPB_DIR . '/src/debug.php';
        require WPPB_DIR . '/src/scripts.php';

        require WPPB_DIR . '/inc/inc.php';
    }
    
}, 100);