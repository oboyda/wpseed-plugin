<?php

/*
 * Register plugin textdomain
 * ----------------------------------------
 */
add_action('init', 'wpboot_load_textdomain');

function wpboot_load_textdomain()
{
    load_plugin_textdomain('wpboot', false, WPBOOT_DIR . '/langs');
}
