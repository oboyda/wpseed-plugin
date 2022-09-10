<?php 

namespace WPPBOOT\Action;

use WPPBOOT\Utils_Product;

class Settings 
{
    public function __construct()
    {
        $this->initSettings();
    }

    static function initSettings()
    {
        global $wppboot_settings;
        $wppboot_settings = new \WPSEED\Settings([
            'prefix' => 'wppboot_',
            'menu_page' => 'options-general.php', // https://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
            'menu_title' => __('WPPBOOT Options', 'wppboot'),
            'page_title' => __('WPPBOOT Options', 'wppboot'),
            'btn_title' => __('Update', 'wppboot')
        ], 
        [
            'general' => [
                'title' => __('General', 'wppboot'),
                'fields' => [
                    'option_name' => [
                        'title' => __('Option name', 'wppboot'),
                        'type' => 'text'
                    ]
                ]
            ]
        ]);
    }
}