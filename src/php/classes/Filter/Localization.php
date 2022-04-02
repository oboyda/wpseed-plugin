<?php 

namespace TILEC\Filter;

class Localization 
{
    public function __construct()
    {
        add_filter('js_index_vars', __CLASS__ . '::addTranslatedStrings');
    }

    static function addTranslatedStrings($index_vars)
    {
        $index_vars['translations'] = [
            'tileOptions' => [
                'title' => __('Select tile', 'tilec')
            ],
            'tileEdit' => [
                'title' => __('Edit tile', 'tilec'),
                'tools' => [
                    'rotateToolsLabel' => __("Rotate", 'tilec'),
                    'rotateLeftLabel' => __("Left", 'tilec'),
                    'rotateRightLabel' => __("Right", 'tilec'),

                    'moveToolsLabel' => __("Move", 'tilec'),
                    
                    'colorToolsLabel' => __("Colors", 'tilec'),

                    'miscToolsLabel' => __("Various", 'tilec'),
                    'removeLabel' => __("Remove", 'tilec')
                ]
            ]
        ];
        
        return $index_vars;
    }
}