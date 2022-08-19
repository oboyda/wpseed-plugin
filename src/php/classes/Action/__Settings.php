<?php 

namespace WPPB\Action;

use WPPB\Utils_Product;

class Settings 
{
    public function __construct()
    {
        $this->initSettings();
    }

    static function initSettings()
    {
        global $wppb_settings;
        $wppb_settings = new \WPSEED\Settings([
            'prefix' => 'wppb_',
            'menu_page' => 'options-general.php', // https://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
            'menu_title' => __('WPPB Options', 'wppb'),
            'page_title' => __('WPPB Options', 'wppb'),
            'btn_title' => __('Update', 'wppb')
        ], 
        [
            'general' => [
                'title' => __('General', 'wppb'),
                'fields' => [
                    'option_name' => [
                        'title' => __('Option name', 'wppb'),
                        'type' => 'text'
                    ]
                ]
            ]
        ]);
    }
}