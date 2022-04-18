<?php 

function tilec_get_view($view_name, $args=[], $echo=false)
{
    return wpseed_get_view($view_name, $args, $echo, TILEC_DIR . '/src/php/views', '\TILEC\View');
}

function tilec_print_view($view_name, $args=[])
{
    tilec_get_view($view_name, $args, true);
}

$tilec_settings = null;
function tilec_get_option($name, $default=null)
{
    global $tilec_settings;
    $opt = isset($tilec_settings) ? $tilec_settings->get_option($name) : false;
    return (empty($opt) && isset($default)) ? $default : $opt;
}