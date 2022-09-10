<?php

/*
 * Register scripts
 * ----------------------------------------
 */
add_action('wp_enqueue_scripts', 'wppboot_register_scripts');
add_action('admin_enqueue_scripts', 'wppboot_register_styles');

function wppboot_register_scripts()
{
    $asset_file = WPPBOOT_DIR . '/build/front.asset.php';
    if(file_exists($asset_file))
    {
        $asset = include($asset_file);

        wp_register_script(
            'wppboot-front',
            WPPBOOT_INDEX . '/build/front.js',
            $asset['dependencies'],
            $asset['version'],
            true
        );
    }

    $asset_file = WPPBOOT_DIR . '/build/admin.asset.php';
    if(file_exists($asset_file))
    {
        $asset = include($asset_file);

        wp_register_script(
            'wppboot-admin',
            WPPBOOT_INDEX . '/build/admin.js',
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
add_action('wp_enqueue_scripts', 'wppboot_register_styles');
add_action('admin_enqueue_scripts', 'wppboot_register_styles');

function wppboot_register_styles()
{
    $asset_file = WPPBOOT_DIR . '/build/front.asset.php';
    if(file_exists($asset_file))
    {
        $asset = include($asset_file);

        wp_register_style(
            'wppboot-front',
            WPPBOOT_INDEX . '/build/front.css',
            // $asset['dependencies'],
            [],
            $asset['version']
        );
    }

    $asset_file = WPPBOOT_DIR . '/build/admin.asset.php';
    if(file_exists($asset_file))
    {
        $asset = include($asset_file);

        wp_register_style(
            'wppboot-admin',
            WPPBOOT_INDEX . '/build/admin.css',
            // $asset['dependencies'],
            [],
            $asset['version']
        );
    }
}

/*
 * Enqueue scripts on FRONT
 * ----------------------------------------
 */
add_action('wp_enqueue_scripts', 'wppboot_enqueue_scripts_front');

function wppboot_enqueue_scripts_front()
{
    wp_enqueue_script('wppboot-front');
    wp_localize_script('wppboot-front', 'wppbootFrontVars', apply_filters('wppboot_js_front_vars', [
        'ajaxurl' => admin_url('admin-ajax.php')
    ]));
}

/*
 * Enqueue scripts on ADMIN
 * ----------------------------------------
 */
add_action('admin_enqueue_scripts', 'wppboot_enqueue_scripts_admin');

function wppboot_enqueue_scripts_admin()
{
    wp_enqueue_script('wppboot-admin');
    wp_localize_script('wppboot-admin', 'wppbootAdminVars', apply_filters('wppboot_js_admin_vars', []));
}

/*
 * Enqueue styles on FRONT
 * ----------------------------------------
 */
add_action('wp_enqueue_scripts', 'wppboot_enqueue_styles_front');

function wppboot_enqueue_styles_front()
{
    wp_enqueue_style('wppboot-front');
}

/*
 * Enqueue styles on ADMIN
 * ----------------------------------------
 */
add_action('admin_enqueue_scripts', 'wppboot_enqueue_styles_admin');

function wppboot_enqueue_styles_admin()
{
    wp_enqueue_style('wppboot-admin');
}
