<?php

namespace PBOOT\Mod\Post_List\View;

class Post_List_Nofound extends \PBOOT\View\View 
{
    const MOD_NAME = 'Post_List';

    public function __construct($args, $default_args=[])
    {
        parent::__construct($args, wp_parse_args($default_args, [
            
            'nofound_text' => __('No items found', 'pboot')
        ]));
    }
}