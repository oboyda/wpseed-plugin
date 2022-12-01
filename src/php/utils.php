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
