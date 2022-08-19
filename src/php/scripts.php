<?php

/*
 * Register scripts
 * ----------------------------------------
 */
add_action('init', 'wppb_register_scripts');

function wppb_register_scripts()
{
    $asset_file = WPPB_DIR . '/build/index.asset.php';

    if(file_exists($asset_file))
    {
        $asset = include($asset_file);

        wp_register_script(
            'wppb-index',
            WPPB_INDEX . '/build/index.js',
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
add_action('init', 'wppb_register_styles');

function wppb_register_styles()
{
    $asset_file = WPPB_DIR . '/build/style.asset.php';

    if(file_exists($asset_file))
    {
        $asset = include($asset_file);

        wp_register_style(
            'wppb-style',
            WPPB_INDEX . '/build/style.css',
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
//add_action('admin_enqueue_scripts', 'wppb_enqueue_scripts_admin');

function wppb_enqueue_scripts_admin()
{
    // wp_enqueue_script('wppb-admin');

    // wp_localize_script('wppb-admin', 'wppbAdminVars', apply_filters('wppb_admin_vars', []));
}

/*
 * Enqueue styles on ADMIN
 * ----------------------------------------
 */
// add_action('admin_enqueue_scripts', 'wppb_enqueue_styles_admin');

function wppb_enqueue_styles_admin()
{
    // wp_enqueue_style('wppb-admin');
}

/*
 * Enqueue scripts on FRONT
 * ----------------------------------------
 */
// add_action('wp_enqueue_scripts', 'wppb_enqueue_scripts');

function wppb_enqueue_scripts()
{
    wp_enqueue_script('wppb-index');
    
    wp_localize_script('wppb-index', 'wppbIndexVars', apply_filters('wppb_js_index_vars', [
        'ajaxurl' => admin_url('admin-ajax.php')
    ]));
}

/*
 * Enqueue styles on FRONT
 * ----------------------------------------
 */
// add_action('wp_enqueue_scripts', 'wppb_enqueue_styles');

function wppb_enqueue_styles()
{
    global $post;
    
    wp_enqueue_style('wppb-style');
}
