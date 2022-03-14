<?php

/*
 * Register plugin textdomain
 * ----------------------------------------
 */
add_action('init', 'wppb_load_textdomain');

function wppb_load_textdomain()
{
    load_plugin_textdomain('wppb', false, WPPB_DIR . '/langs');
}

/*
 * Setup values for oboyda/wp-seed package
 * ----------------------------------------
 */
add_filter('wpseed_views_dir', 'wppb_filter_views_dir');

function wppb_filter_views_dir()
{
    return WPPB_DIR . '/src/views';
}

add_filter('wpseed_views_namespace', 'wppb_filter_views_namespace');

function wppb_filter_views_namespace()
{
    return '\WPPB\View';
}
