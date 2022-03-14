<?php 

function wpboot_get_view($view_name, $args=[], $echo=false)
{
    return wpseed_get_view($view_name, $args, $echo, WPBOOT_DIR . '/src/php/views', '\WPBOOT\View');
}

function wpboot_print_view($view_name, $args=[])
{
    wpboot_get_view($view_name, $args, true);
}
