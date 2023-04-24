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
            'input_class' => '',
            'input_label' => '',
            'label_class' => '',
            'required' => true,
            'multiple' => false
        ]);

        $this->setHtmlClass();
    }

    private function setHtmlClass()
    {
        if($this->has_input_label()):
            $this->addHtmlClass('has-input-label');
        endif;
    }

    public function getInputName()
    {
        return $this->args['multiple'] ? $this->args['input_name'] . '[]' : $this->args['input_name'];
    }
}