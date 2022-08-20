<?php
/**
 * Plugin Name: WPPBOOT
 * Description: WPPBOOT Plugin
 * Version: 1.0
 * Author: Alexis Boyda
 * Author URI: https://aleapp.com
 * Text Domain: wppboot
 */

define('WPPBOOT_NAME', 'WPPBOOT Plugin');
define('WPPBOOT_VERSION', '1.0');
define('WPPBOOT_DIR', dirname(__FILE__));
define('WPPBOOT_INDEX', plugins_url('', __FILE__));

add_action('plugins_loaded', function()
{
    require WPPBOOT_DIR . '/src/php/setup.php';
    require WPPBOOT_DIR . '/vendor/autoload.php';
    
    $deps = new \WPPBOOT\Deps([
       'woocommerce/woocommerce.php'
    ]);
    
    if($deps->check())
    {
        require WPPBOOT_DIR . '/src/php/utils.php';
        require WPPBOOT_DIR . '/src/php/classes/load.php';
        require WPPBOOT_DIR . '/src/php/debug.php';
        require WPPBOOT_DIR . '/src/php/scripts.php';
        require WPPBOOT_DIR . '/src/php/shortcodes.php';
    }
    
}, 100);