<?php

namespace PBOOT\Mod\Form_Advanced\View;

class Form_Input_Location extends \PBOOT\View\View 
{
    public function __construct($args)
    {
        parent::__construct($args, [
            'input_name' => 'location',
            'input_label' => __('Location', 'pboot')
        ]);
    }
}
