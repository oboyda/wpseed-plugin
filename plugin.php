<?php
/**
 * Plugin Name: Homeselect Plugin
 * Description: Bootstrap plugin that makes it easier to start a new plugin development
 * Version: 1.0.0
 * Author: Alexis Boyda
 * Author URI: https://aleapp.com
 * Text Domain: hsp
 */

define('HSP_NAME', 'Homeselect Plugin');
define('HSP_VERSION', '1.0.0');
define('HSP_DIR', dirname(__FILE__));
define('HSP_INDEX', plugins_url('', __FILE__));

add_action('plugins_loaded', function()
{
    require HSP_DIR . '/src/setup.php';
    require HSP_DIR . '/vendor/autoload.php';
    
    $deps = new \HSP\Deps([
//        'woocommerce/woocommerce.php'
    ]);
    
    if($deps->check())
    {
        require HSP_DIR . '/src/utils.php';
        require HSP_DIR . '/src/classes/load.php';
        require HSP_DIR . '/src/debug.php';
        require HSP_DIR . '/src/scripts.php';

        require HSP_DIR . '/inc/inc.php';
    }
    
}, 100);