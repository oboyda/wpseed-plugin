<?php 

namespace PBOOT\Action;

class Settings 
{
    public function __construct()
    {
        $this->initSettings();
    }

    public function initSettings()
    {
        if(!is_admin())
        {
            return false;
        }

        $settings = new \WPSEED\Settings([
            'prefix' => 'pboot_',
            'menu_page' => 'options-general.php', // https://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
            'menu_title' => __('PBOOT Options', 'pboot'),
            'page_title' => __('PBOOT Options', 'pboot'),
            'btn_title' => __('Update', 'pboot')
        ], 
        [
            'general' => [
                'title' => __('Goolge Maps', 'pboot'),
                'fields' => [
                    'googlemaps_api_key' => [
                        'title' => __('API key', 'pboot'),
                        'type' => 'text'
                    ]
                ]
            ]
        ]);
    }
}