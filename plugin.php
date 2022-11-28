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

require PBOOT_DIR . '/vendor/autoload.php';

$pboot_setup = new \WPSEEDE\Setup([

    'plugin_name' => PBOOT_NAME,
    'context_name' => 'pboot',
    'textdom' => 'pboot',
    'base_dir' => PBOOT_DIR,
    'base_dir_url' => PBOOT_INDEX,
    'version' => PBOOT_VERSION,

    'plugin_deps' => [
        // 'woocommerce/woocommerce.php'
    ],

    // 'settings_config' => require PBOOT_DIR . '/config/settings.php',

    'include_files' => [
        'src/php/utils.php',
        'config/acf-blocks.php',
        'config/acf-fields.php'
    ]
]);
$pboot_setup->initScripts();
$pboot_setup->initTheme([
    'theme_menus' => [
        'top' => __('Top menu', 'pboot'),
        'primary' => __('Primary menu', 'pboot')
    ]
]);