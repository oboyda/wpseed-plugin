<?php

namespace PBOOT\View;

class Site_Modal extends View 
{
    public function __construct($args)
    {
        parent::__construct($args, [
            
            'title' => '&nbsp',
            'body_content' => 'Modal content goes here'
        ]);
    }
}
