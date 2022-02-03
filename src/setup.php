<?php

/*
 * Register plugin textdomain
 * ----------------------------------------
 */
add_action('init', 'hsp_load_textdomain');

function hsp_load_textdomain()
{
    load_plugin_textdomain('hsp', false, HSP_DIR . '/langs');
}

/*
 * Setup values for oboyda/wp-seed package
 * ----------------------------------------
 */
// add_filter('wpseed_views_dir', 'hsp_filter_views_dir');

// function hsp_filter_views_dir()
// {
//     return HSP_DIR . '/src/views';
// }

// add_filter('wpseed_views_namespace', 'hsp_filter_views_namespace');

// function hsp_filter_views_namespace()
// {
//     return '\HSP\View';
// }
