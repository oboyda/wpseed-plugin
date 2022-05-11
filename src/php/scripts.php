<?php

/*
 * Register scripts
 * ----------------------------------------
 */
add_action('init', 'wpboot_register_scripts');

function wpboot_register_scripts()
{
    $asset_file = WPBOOT_DIR . '/build/index.asset.php';

    if(file_exists($asset_file))
    {
        $asset = include($asset_file);

        wp_register_script(
            'wpboot-index',
            WPBOOT_INDEX . '/build/index.js',
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
add_action('init', 'wpboot_register_styles');

function wpboot_register_styles()
{
    $asset_file = WPBOOT_DIR . '/build/style.asset.php';

    if(file_exists($asset_file))
    {
        $asset = include($asset_file);

        wp_register_style(
            'wpboot-style',
            WPBOOT_INDEX . '/build/style.css',
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
//add_action('admin_enqueue_scripts', 'wpboot_enqueue_scripts_admin');

function wpboot_enqueue_scripts_admin()
{
    // wp_enqueue_script('wpboot-admin');

    // wp_localize_script('wpboot-admin', 'wpbootAdminVars', apply_filters('wpboot_admin_vars', []));
}

/*
 * Enqueue styles on ADMIN
 * ----------------------------------------
 */
// add_action('admin_enqueue_scripts', 'wpboot_enqueue_styles_admin');

function wpboot_enqueue_styles_admin()
{
    // wp_enqueue_style('wpboot-admin');
}

/*
 * Enqueue scripts on FRONT
 * ----------------------------------------
 */
// add_action('wp_enqueue_scripts', 'wpboot_enqueue_scripts');

function wpboot_enqueue_scripts()
{
    wp_enqueue_script('wpboot-index');
    
    wp_localize_script('wpboot-index', 'wpbootIndexVars', apply_filters('wpboot_js_index_vars', [
        'ajaxurl' => admin_url('admin-ajax.php')
    ]));
}

/*
 * Enqueue styles on FRONT
 * ----------------------------------------
 */
// add_action('wp_enqueue_scripts', 'wpboot_enqueue_styles');

function wpboot_enqueue_styles()
{
    global $post;
    
    wp_enqueue_style('wpboot-style');
}
