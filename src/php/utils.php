<?php 

function pboot_get_view($view_name, $args=[], $echo=false)
{
    return wpseed_get_view($view_name, $args, $echo, PBOOT_DIR . '/src/php/View/html', '\PBOOT\View');
}

function pboot_print_view($view_name, $args=[])
{
    pboot_get_view($view_name, $args, true);
}

function pboot_get_mod_view($mod, $view_name, $args=[], $echo=false)
{
    return wpseed_get_view($view_name, $args, $echo, PBOOT_DIR . '/mods/' . $mod . '/View/html', '\PBOOT\\Mod\\' . $mod . '\View');
}

function pboot_print_mod_view($mod, $view_name, $args=[])
{
    pboot_get_mod_view($mod, $view_name, $args, true);
}
