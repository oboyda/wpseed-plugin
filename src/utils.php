<?php

function hsp_get_view($view_name, $args=[], $echo=false)
{
    return wpseed_get_view($view_name, $args, $echo, HSP_DIR . '/src/views', '\HSP\View');
}

function hsp_print_view($view_name, $args=[])
{
    hsp_get_view($view_name, $args, true);
}
