<?php

namespace PBOOT\View;

class View extends \WPSEEDE\View 
{
    // const CONTEXT_NAME = 'pboot';

    public function __construct($args, $default_args=[])
    {
        global $pboot_setup;
        parent::__construct($args, wp_parse_args($default_args, [
            'view_loader' => $pboot_setup->view_loader,
            'context_name' => $pboot_setup->context_name
        ]));
    }
}
