<?php

namespace PBOOT\View;

class View extends \WPSEEDE\View 
{
    // const CONTEXT_NAME = 'pboot';

    public function __construct($args, $default_args=[])
    {
        global $pboot_setup;

        $this->context_name = $pboot_setup->context_name;
        $this->view_loader = $pboot_setup->view_loader;

        parent::__construct($args, wp_parse_args($default_args, [
            
        ]));
    }
}
