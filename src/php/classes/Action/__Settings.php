<?php 

namespace WPBOOT\Action;

use WPBOOT\Utils_Product;

class Settings 
{
    public function __construct()
    {
        $this->initSettings();
    }

    static function initSettings()
    {
        global $wpboot_settings;
        $wpboot_settings = new \WPSEED\Settings([
            'prefix' => 'wpboot_',
            'menu_page' => 'options-general.php', // https://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
            'menu_title' => __('WPBOOT Options', 'wpboot'),
            'page_title' => __('WPBOOT Options', 'wpboot'),
            'btn_title' => __('Update', 'wpboot')
        ], 
        [
            'general' => [
                'title' => __('General', 'wpboot'),
                'fields' => [
                    'option_name' => [
                        'title' => __('Option name', 'wpboot'),
                        'type' => 'text'
                    ]
                ]
            ]
        ]);
    }
}