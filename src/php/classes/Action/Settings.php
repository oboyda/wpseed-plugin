<?php 

namespace TILEC\Action;

class Settings 
{
    public function __construct()
    {
        $this->initSettings();
    }

    static function initSettings()
    {
        global $tilec_settings;
        $tilec_settings = new \WPSEED\Settings([
            'prefix' => 'tilec_',
            'menu_page' => 'options-general.php', // https://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
            'menu_title' => __('Art Creator Options', 'tilec'),
            'page_title' => __('Art Creator Options', 'tilec'),
            'btn_title' => __('Update', 'tilec')
        ], 
        [
            'product' => [
                'title' => __('Product', 'tilec'),
                'fields' => [
                    'tile_size' => [
                        'title' => __('Tile size', 'tilec'),
                        'type' => 'text'
                    ],
                    'tiles_min_x' => [
                        'title' => __('Grid min width', 'tilec'),
                        'type' => 'text'
                    ],
                    'tiles_min_y' => [
                        'title' => __('Grid min height', 'tilec'),
                        'type' => 'text'
                    ],
                    'tiles_max_x' => [
                        'title' => __('Grid max width', 'tilec'),
                        'type' => 'text'
                    ],
                    'tiles_max_y' => [
                        'title' => __('Grid max height', 'tilec'),
                        'type' => 'text'
                    ]
                ]
            ]
        ]);
    }
}