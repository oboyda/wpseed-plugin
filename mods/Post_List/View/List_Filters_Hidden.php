<?php

namespace PBOOT\Mod\Post_List\View;

class List_Filters_Hidden extends Post_List_Filters_Form 
{
    const MOD_NAME = 'Post_List';

    public function __construct($args, $default_args=[])
    {
        parent::__construct($args, $default_args);
    }
}