<?php 

function wppboot_get_view($view_name, $args=[], $echo=false)
{
    return wpseed_get_view($view_name, $args, $echo, WPPBOOT_DIR . '/src/php/views', '\WPPBOOT\View');
}

function wppboot_print_view($view_name, $args=[])
{
    wppboot_get_view($view_name, $args, true);
}

$wppboot_settings = null;
function wppboot_get_option($name, $default=null)
{
    global $wppboot_settings;
    $opt = isset($wppboot_settings) ? $wppboot_settings->get_option($name) : false;
    return (empty($opt) && isset($default)) ? $default : $opt;
}