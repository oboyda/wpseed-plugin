<?php

/*
* Register plugin textdomain
* ----------------------------------------
*/
add_action('init', 'pboot_load_textdomain');

function pboot_load_textdomain()
{
    load_plugin_textdomain('pboot', false, PBOOT_DIR . '/langs');
}
