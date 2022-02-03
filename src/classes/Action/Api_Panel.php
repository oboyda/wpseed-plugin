<?php 

namespace HSP\Action;

use WPSEED\Req;

class Api_Panel 
{
    public function __construct()
    {
        add_action('admin_menu', __CLASS__ . '::addAdminPanel');
    }

    static function addAdminPanel(){
        add_submenu_page(
            'edit.php?post_type=property',
            __('API Import', 'hsp'),
            __('API Import', 'hsp'),
            'manage_options',
            'hsp_api_panel',
            __CLASS__ . '::displayAdminPanel'
        );
    }

    static function displayAdminPanel()
    {
        hsp_print_view('api-panel');
    }
}