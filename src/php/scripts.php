<?php

/*
 * Register scripts
 * ----------------------------------------
 */
add_action('wp_enqueue_scripts', 'pboot_register_scripts');
add_action('admin_enqueue_scripts', 'pboot_register_styles');

function pboot_register_scripts()
{
    $asset_file = PBOOT_DIR . '/build/front.asset.php';
    if(file_exists($asset_file))
    {
        $asset = include($asset_file);

        wp_register_script(
            'pboot-front',
            PBOOT_INDEX . '/build/front.js',
            $asset['dependencies'],
            $asset['version'],
            true
        );
    }

    $asset_file = PBOOT_DIR . '/build/admin.asset.php';
    if(file_exists($asset_file))
    {
        $asset = include($asset_file);

        wp_register_script(
            'pboot-admin',
            PBOOT_INDEX . '/build/admin.js',
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
add_action('wp_enqueue_scripts', 'pboot_register_styles');
add_action('admin_enqueue_scripts', 'pboot_register_styles');

function pboot_register_styles()
{
    $asset_file = PBOOT_DIR . '/build/front.asset.php';
    if(file_exists($asset_file))
    {
        $asset = include($asset_file);

        wp_register_style(
            'pboot-front',
            PBOOT_INDEX . '/build/front.css',
            // $asset['dependencies'],
            [],
            $asset['version']
        );
    }

    $asset_file = PBOOT_DIR . '/build/admin.asset.php';
    if(file_exists($asset_file))
    {
        $asset = include($asset_file);

        wp_register_style(
            'pboot-admin',
            PBOOT_INDEX . '/build/admin.css',
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
// add_action('wp_enqueue_scripts', 'pboot_enqueue_scripts_front');

function pboot_enqueue_scripts_front()
{
    wp_enqueue_script('pboot-front');
    wp_localize_script('pboot-front', 'pbootFrontVars', apply_filters('pboot_js_front_vars', [
        'ajaxurl' => admin_url('admin-ajax.php')
    ]));
}

/*
 * Enqueue scripts on ADMIN
 * ----------------------------------------
 */
// add_action('admin_enqueue_scripts', 'pboot_enqueue_scripts_admin');

function pboot_enqueue_scripts_admin()
{
    wp_enqueue_script('pboot-admin');
    wp_localize_script('pboot-admin', 'pbootAdminVars', apply_filters('pboot_js_admin_vars', []));
}

/*
 * Enqueue styles on FRONT
 * ----------------------------------------
 */
// add_action('wp_enqueue_scripts', 'pboot_enqueue_styles_front');

function pboot_enqueue_styles_front()
{
    wp_enqueue_style('pboot-front');
}

/*
 * Enqueue styles on ADMIN
 * ----------------------------------------
 */
// add_action('admin_enqueue_scripts', 'pboot_enqueue_styles_admin');

function pboot_enqueue_styles_admin()
{
    wp_enqueue_style('pboot-admin');
}
