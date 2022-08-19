<?php 

function wppb_get_view($view_name, $args=[], $echo=false)
{
    return wpseed_get_view($view_name, $args, $echo, WPPB_DIR . '/src/php/views', '\WPPB\View');
}

function wppb_print_view($view_name, $args=[])
{
    wppb_get_view($view_name, $args, true);
}

$wppb_settings = null;
function wppb_get_option($name, $default=null)
{
    global $wppb_settings;
    $opt = isset($wppb_settings) ? $wppb_settings->get_option($name) : false;
    return (empty($opt) && isset($default)) ? $default : $opt;
}