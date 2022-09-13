<?php 

namespace PBOOT\Action;

use PBOOT\Utils_Product;

class Settings 
{
    public function __construct()
    {
        $this->initSettings();
    }

    static function initSettings()
    {
        global $pboot_settings;
        $pboot_settings = new \WPSEED\Settings([
            'prefix' => 'pboot_',
            'menu_page' => 'options-general.php', // https://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
            'menu_title' => __('PBOOT Options', 'pboot'),
            'page_title' => __('PBOOT Options', 'pboot'),
            'btn_title' => __('Update', 'pboot')
        ], 
        [
            'general' => [
                'title' => __('General', 'pboot'),
                'fields' => [
                    'option_name' => [
                        'title' => __('Option name', 'pboot'),
                        'type' => 'text'
                    ]
                ]
            ]
        ]);
    }
}