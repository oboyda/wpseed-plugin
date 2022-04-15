<?php 

namespace TILEC\Filter;

class Settings 
{
    public function __construct()
    {
        add_filter('js_index_vars', __CLASS__ . '::addJsVarsGridSize');
        add_filter('js_index_vars', __CLASS__ . '::addJsVarsStrings');
    }

    static function addJsVarsGridSize($js_vars)
    {
        $js_vars['grid_size'] = [
            'tile_size' => 15, #cm
            'tiles_max_x' => 100,
            'tiles_max_y' => 100
        ];

        return $js_vars;
    }

    static function addJsVarsStrings($js_vars)
    {
        $js_vars['strings'] = [
            'tileOptions' => [
                'title' => __('Select tile', 'tilec')
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
            ]
        ];
        
        return $js_vars;
    }
}