<?php
/**
 * Plugin Name: WPSEED Plugin
 * Description: WPSEED Plugin Bootstrap
 * Version: 1.0.0
 * Author: Alexis Boyda
 * Author URI: https://aleapp.com
 * Text Domain: pboot
 */

define('PBOOT_NAME', 'WPSEED Plugin Bootstrap');
define('PBOOT_VERSION', '1.0.0');
define('PBOOT_DIR', dirname(__FILE__));
define('PBOOT_INDEX', plugins_url('', __FILE__));

require PBOOT_DIR . '/vendor/autoload.php';

$pboot_setup = new \WPSEEDE\Setup([

    'plugin_name' => PBOOT_NAME,
    'context_name' => 'pboot',
    'namespace' => 'PBOOT',
    'textdom' => 'pboot',
    'base_dir' => PBOOT_DIR,
    'base_dir_url' => PBOOT_INDEX,
    'version' => PBOOT_VERSION,

    'plugin_deps' => [
        // 'woocommerce/woocommerce.php'
    ],

    'settings_config' => require PBOOT_DIR . '/config/settings.php',

    'include_files' => [
        'src/php/class-load.php',
        'src/php/utils.php',
        'config/acf-blocks.php',
        'config/acf-fields.php'
    ],

    'load_modules' => [
        'Boot_Styler',
        'Form_Advanced',
        'Post_List',
        // 'User_Login',
        // 'Action_Email',
        // 'Site_Loader',
        // 'Site_Modal',
        // 'Status_Message',
        // 'Tabs_Content',
    ]
    // 'load_modules' => 'all'
]);
$pboot_setup->initScripts([
    // 'style_regs' => [
    //     'fonts' => PBOOT_INDEX . '/assets/fonts/fonts.css'
    // ]
]);
$pboot_setup->initTheme([
    'theme_menus' => [
        'top' => __('Top menu', 'pboot'),
        'primary' => __('Primary menu', 'pboot')
    ]
]);