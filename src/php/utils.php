<?php 

function tilec_get_view($view_name, $args=[], $echo=false)
{
    return wpseed_get_view($view_name, $args, $echo, TILEC_DIR . '/src/php/views', '\TILEC\View');
}

function tilec_print_view($view_name, $args=[])
{
    tilec_get_view($view_name, $args, true);
}
