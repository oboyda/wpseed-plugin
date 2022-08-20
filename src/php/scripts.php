<?php

/*
 * Register scripts
 * ----------------------------------------
 */
add_action('init', 'wppboot_register_scripts');

function wppboot_register_scripts()
{
    $asset_file = WPPBOOT_DIR . '/build/index.asset.php';

    if(file_exists($asset_file))
    {
        $asset = include($asset_file);

        wp_register_script(
            'wppboot-index',
            WPPBOOT_INDEX . '/build/index.js',
            $asset['dependencies'],
            $asset['version'],
            true
        );
    }
}

/*
 * Register styles
 * ----------------------------------------
 */
add_action('init', 'wppboot_register_styles');

function wppboot_register_styles()
{
    $asset_file = WPPBOOT_DIR . '/build/style.asset.php';

    if(file_exists($asset_file))
    {
        $asset = include($asset_file);

        wp_register_style(
            'wppboot-style',
            WPPBOOT_INDEX . '/build/style.css',
            // $asset['dependencies'],
            [],
            $asset['version']
        );
    }
}

/*
 * Enqueue scripts on ADMIN
 * ----------------------------------------
 */
//add_action('admin_enqueue_scripts', 'wppboot_enqueue_scripts_admin');

function wppboot_enqueue_scripts_admin()
{
    // wp_enqueue_script('wppboot-admin');

    // wp_localize_script('wppboot-admin', 'wppbootAdminVars', apply_filters('wppboot_admin_vars', []));
}

/*
 * Enqueue styles on ADMIN
 * ----------------------------------------
 */
// add_action('admin_enqueue_scripts', 'wppboot_enqueue_styles_admin');

function wppboot_enqueue_styles_admin()
{
    // wp_enqueue_style('wppboot-admin');
}

/*
 * Enqueue scripts on FRONT
 * ----------------------------------------
 */
// add_action('wp_enqueue_scripts', 'wppboot_enqueue_scripts');

function wppboot_enqueue_scripts()
{
    wp_enqueue_script('wppboot-index');
    
    wp_localize_script('wppboot-index', 'wppbootIndexVars', apply_filters('wppboot_js_index_vars', [
        'ajaxurl' => admin_url('admin-ajax.php')
    ]));
}

/*
 * Enqueue styles on FRONT
 * ----------------------------------------
 */
// add_action('wp_enqueue_scripts', 'wppboot_enqueue_styles');

function wppboot_enqueue_styles()
{
    global $post;
    
    wp_enqueue_style('wppboot-style');
}
