<?php 

namespace PBOOT\Mod\Status_Message\Action\View;

class Status_Popup 
{
    public function __construct()
    {
        add_action('wp_footer', [$this, 'printPopup']);
    }

    public function printPopup()
    {
        pboot_print_view('Status_Message/status-popup');
    }
}