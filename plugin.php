<?php
/**
 * Plugin Name: PBOOT
 * Description: PBOOT Plugin
 * Version: 1.0
 * Author: Alexis Boyda
 * Author URI: https://aleapp.com
 * Text Domain: pboot
 */

define('PBOOT_NAME', 'PBOOT Plugin');
define('PBOOT_VERSION', '1.0');
define('PBOOT_DIR', dirname(__FILE__));
define('PBOOT_INDEX', plugins_url('', __FILE__));

add_action('plugins_loaded', function()
{
    require PBOOT_DIR . '/src/php/setup.php';
    require PBOOT_DIR . '/vendor/autoload.php';
    require PBOOT_DIR . '/src/php/utils.php';
    
    $deps = new \WPSEED\Deps([
    //    'woocommerce/woocommerce.php'
    ], [
        'plugin_name' => PBOOT_NAME
    ]);
    
    if($deps->check())
    {
        require PBOOT_DIR . '/src/php/class-load.php';
        require PBOOT_DIR . '/src/php/mods.php';
        require PBOOT_DIR . '/src/php/scripts.php';
        require PBOOT_DIR . '/src/php/acf-fields.php';
        // require PBOOT_DIR . '/src/php/debug.php';
    }
    
}, 100);