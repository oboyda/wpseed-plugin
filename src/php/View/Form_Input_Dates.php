<?php

namespace PBOOT\View;

class Form_Input_Dates extends View 
{
    public function __construct($args)
    {
        parent::__construct($args, [
            
            'input_name_from' => '',
            'input_name_till' => '',
            'label_from' => __('Date from', 'pboot'),
            'label_till' => __('Date till', 'pboot')
        ]);
    }
}
