<?php

/*
 * Register scripts
 * ----------------------------------------
 */
add_action('init', 'tilec_register_scripts');

function tilec_register_scripts()
{
    $asset_file = TILEC_DIR . '/build/index.asset.php';

    if(file_exists($asset_file))
    {
        $asset = include($asset_file);

        wp_register_script(
            'tilec-index',
            TILEC_INDEX . '/build/index.js',
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
add_action('init', 'tilec_register_styles');

function tilec_register_styles()
{
    $asset_file = TILEC_DIR . '/build/style.asset.php';

    if(file_exists($asset_file))
    {
        $asset = include($asset_file);

        wp_register_style(
            'tilec-style',
            TILEC_INDEX . '/build/style.css',
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
//add_action('admin_enqueue_scripts', 'tilec_enqueue_scripts_admin');

function tilec_enqueue_scripts_admin()
{
    // wp_enqueue_script('tilec-admin');

    // wp_localize_script('tilec-admin', 'tilecAdminVars', apply_filters('tilec_admin_vars', []));
}

/*
 * Enqueue styles on ADMIN
 * ----------------------------------------
 */
// add_action('admin_enqueue_scripts', 'tilec_enqueue_styles_admin');

function tilec_enqueue_styles_admin()
{
    // wp_enqueue_style('tilec-admin');
}

/*
 * Enqueue scripts on FRONT
 * ----------------------------------------
 */

add_action('wp_enqueue_scripts', 'tilec_enqueue_scripts');

function tilec_enqueue_scripts()
{
    wp_enqueue_script('tilec-index');
    
    wp_localize_script('tilec-index', 'indexVars', apply_filters('js_index_vars', [
        'ajaxurl' => admin_url('admin-ajax.php')
    ]));
}

/*
 * Enqueue styles on FRONT
 * ----------------------------------------
 */

add_action('wp_enqueue_scripts', 'tilec_enqueue_styles');

function tilec_enqueue_styles()
{
    global $post;
    
    wp_enqueue_style('tilec-style');

    if(isset($post) && has_shortcode($post->post_content, 'tiles-configurator'))
    {
        wp_enqueue_style('dashicons');
    }
}
