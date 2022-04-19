<?php 

namespace TILEC\Filter;

use TILEC\Utils_Settings;
use TILEC\Utils_Product;

class Settings 
{
    public function __construct()
    {
        add_filter('js_index_vars', __CLASS__ . '::addJsVarsGridSize');
        add_filter('js_index_vars', __CLASS__ . '::addJsVarsTilesConfig');
        add_filter('js_index_vars', __CLASS__ . '::addJsVarsStrings');
    }

    static function addJsVarsGridSize($js_vars)
    {
        $js_vars['grid_size'] = [
            'tile_size' => Utils_Settings::getTileSize(), #cm
            'tiles_min_x' => Utils_Settings::getGridMinX(true),
            'tiles_min_y' => Utils_Settings::getGridMinY(true),
            'tiles_max_x' => Utils_Settings::getGridMaxX(true),
            'tiles_max_y' => Utils_Settings::getGridMaxY(true)
        ];

        return $js_vars;
    }

    static function addJsVarsTilesConfig($js_vars)
    {
        $js_vars['tiles_config'] = Utils_Product::getProductsTileConfig();

        return $js_vars;
    }

    static function addJsVarsStrings($js_vars)
    {
        $js_vars['strings'] = [
            'tileOptions' => [
                'title' => __('Tile options', 'tilec')
            ],
            'tileEdit' => [
                'title' => __('Edit tile', 'tilec'),
                'tools' => [
                    'rotateToolsLabel' => __('Rotate', 'tilec'),
                    'rotateLeftLabel' => __('Left', 'tilec'),
                    'rotateRightLabel' => __('Right', 'tilec'),

                    'moveToolsLabel' => __('Move', 'tilec'),
                    
                    'colorToolsLabel' => __('Colors', 'tilec'),

                    'miscToolsLabel' => __('Various', 'tilec'),
                    'removeLabel' => __('Remove', 'tilec')
                ]
            ],
            'gridSetup' => [
                'grid_size' => [
                    'group_title' => __('Canvas size', 'tilec'),
                    'group_description' => __('Canvas size', 'tilec'),
                    'size_x_control_label' => __('Width', 'tilec'),
                    'size_y_control_label' => __('Height', 'tilec')
                ],
                'btn_save_label' => __('Save', 'tilec')
            ],
            'navBar' => [
                'btn_set_canvas_label' => __('Canvas size', 'tilec'),
                'btn_continue_label' => __('Continue', 'tilec')
            ]
        ];
        
        return $js_vars;
    }
}