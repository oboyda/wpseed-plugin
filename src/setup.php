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
