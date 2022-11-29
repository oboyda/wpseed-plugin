<?php

namespace PBOOT\View;

class View extends \WPSEEDE\View 
{
    public function __construct($args, $default_args=[])
    {
        parent::__construct($args, wp_parse_args($default_args, [
            'context_name' => 'pboot'
        ]));
    }
}
