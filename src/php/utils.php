<?php 

function wpboot_get_view($view_name, $args=[], $echo=false)
{
    return wpseed_get_view($view_name, $args, $echo, WPBOOT_DIR . '/src/php/views', '\WPBOOT\View');
}

function wpboot_print_view($view_name, $args=[])
{
    wpboot_get_view($view_name, $args, true);
}

$wpboot_settings = null;
function wpboot_get_option($name, $default=null)
{
    global $wpboot_settings;
    $opt = isset($wpboot_settings) ? $wpboot_settings->get_option($name) : false;
    return (empty($opt) && isset($default)) ? $default : $opt;
}