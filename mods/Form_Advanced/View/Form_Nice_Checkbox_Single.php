<?php

namespace PBOOT\Mod\Form_Advanced\View;

class Form_Nice_Checkbox_Single extends Form_Nice_Checkbox 
{
    const MOD_NAME = 'Form_Advanced';

    public function __construct($args)
    {
        parent::__construct($args, [

            'multiple' => false,

            'single_name' => '',
            'single_value' => '',
            'single_icon_html' => '',
            'single_icon_class' => '',

            'checked' => false,

            'input_type' => 'checkbox'
        ]);

        $this->_setArgs();
        $this->_setOptions();
        $this->__setHtmlClass();
    }

    protected function _setArgs()
    {
        if($this->args['checked'])
        {
            $this->args['selected'] = [$this->args['single_value']];
        }

        $this->setArgs();
    }

    protected function _setOptions()
    {
        $this->args['options'] = [[
            'name' => $this->args['single_name'],
            'value' => $this->args['single_value'],
            'icon_html' => $this->args['single_icon_html'],
            'icon_class' => $this->args['single_icon_class']
        ]];

        $this->setOptions();
    }

    protected function __setHtmlClass()
    {
        $this->addHtmlClass('form-nice-checkbox');
        $this->_setHtmlClass();
    }
}