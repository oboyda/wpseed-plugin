<?php

/*
 * Register plugin textdomain
 * ----------------------------------------
 */
add_action('init', 'tilec_load_textdomain');

function tilec_load_textdomain()
{
    load_plugin_textdomain('tilec', false, TILEC_DIR . '/langs');
}
