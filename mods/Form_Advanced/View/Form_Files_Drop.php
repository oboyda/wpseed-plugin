<?php

namespace PBOOT\Mod\Form_Advanced\View;

class Form_Files_Drop extends \PBOOT\View\View 
{
    const MOD_NAME = 'Form_Advanced';

    public function __construct($args)
    {
        parent::__construct($args, [
            'input_name' => '',
            'drop_label' => __('Drop files here or choose files below', 'pboot'),
            'multiple' => false
        ]);
    }

    public function getInputName()
    {
        return $this->args['multiple'] ? $this->args['input_name'] . '[]' : $this->args['input_name'];
    }
}