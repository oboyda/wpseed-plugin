<?php

/*
 * Register scripts
 * ----------------------------------------
 */
add_action('init', 'hsp_register_scripts');

function hsp_register_scripts()
{
    //wp_register_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js', [], null);
    //wp_register_script('vue', 'https://unpkg.com/vue@next', [], null);
    //wp_register_script('axios', 'https://unpkg.com/axios/dist/axios.min.js', [], null);
    //wp_register_script('qs', 'https://unpkg.com/qs/dist/qs.js', [], null);
}

/*
 * Register styles
 * ----------------------------------------
 */
add_action('init', 'hsp_register_styles');

function hsp_register_styles()
{
    wp_register_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css', [], null);
    wp_register_style('hsp-views', HSP_INDEX . '/css/views.css', [], HSP_VERSION);
}

/*
 * Enqueue scripts on admin
 * ----------------------------------------
 */
//add_action('admin_enqueue_scripts', 'hsp_enqueue_scripts_admin');

function hsp_enqueue_scripts_admin()
{
    //...
}

/*
 * Enqueue styles on admin
 * ----------------------------------------
 */
//add_action('admin_enqueue_scripts', 'hsp_enqueue_styles_admin');

function hsp_enqueue_styles_admin()
{
    //...
}

/*
 * Enqueue scripts on front
 * ----------------------------------------
 */

add_action('wp_enqueue_scripts', 'hsp_enqueue_scripts');

function hsp_enqueue_scripts()
{
    //wp_enqueue_script('bootstrap');
    //wp_enqueue_script('jquery');
    //wp_enqueue_script('vue');
    //wp_enqueue_script('axios');
    //wp_enqueue_script('qs');
    //wp_localize_script('vue', 'vueVars', apply_filters('vue_vars', []));

    wp_localize_script('hsp-front', 'hspFrontVars', apply_filters('hsp_front_vars', [
        'ajaxurl' => admin_url('admin-ajax.php')
    ]));
}

/*
 * Enqueue styles on front
 * ----------------------------------------
 */

add_action('wp_enqueue_scripts', 'hsp_enqueue_styles');

function hsp_enqueue_styles()
{
    //wp_enqueue_style('bootstrap');
    // wp_enqueue_style('hsp-views');
}
