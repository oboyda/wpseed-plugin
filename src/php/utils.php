<?php 

function pboot_get_view_object($view_name, $args=[])
{
    global $pboot_setup;
    return $pboot_setup->view_loader->getViewObject($view_name, $args);
}

function pboot_get_view($view_name, $args=[])
{
    global $pboot_setup;
    return $pboot_setup->view_loader->getView($view_name, $args);
}

function pboot_print_view($view_name, $args=[])
{
    global $pboot_setup;
    $pboot_setup->view_loader->printView($view_name, $args);
}

function pboot_debug($debug, $file_name='__debug.txt', $append=false)
{
    $debug_path = ABSPATH . $file_name;
    $debug_html = is_array($debug) ? print_r($debug, true) : $debug;

    if($append)
    {
        file_put_contents($debug_path, $debug_html, FILE_APPEND);
    }
    else{
        file_put_contents($debug_path, $debug_html);
    }
}