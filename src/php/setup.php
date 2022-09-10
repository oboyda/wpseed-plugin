<?php

/*
* Register plugin textdomain
* ----------------------------------------
*/
add_action('init', 'wppboot_load_textdomain');

function wppboot_load_textdomain()
{
    load_plugin_textdomain('wppboot', false, WPPBOOT_DIR . '/langs');
}
