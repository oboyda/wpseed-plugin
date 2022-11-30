<?php

namespace PBOOT\Mod\Site_Modal\View;

class Site_Modal extends \PBOOT\View\View 
{
    public function __construct($args)
    {
        parent::__construct($args, [
            
            'title' => '&nbsp',
            'body_content' => 'Modal content goes here'
        ]);
    }
}
