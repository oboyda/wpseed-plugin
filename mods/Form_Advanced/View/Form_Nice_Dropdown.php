<?php

namespace PBOOT\Mod\Form_Advanced\View;

class Form_Nice_Dropdown extends \PBOOT\View\View 
{
    const MOD_NAME = 'Form_Advanced';

    public function __construct($args)
    {
        parent::__construct($args, [

            'disabled' => false,
            'enabled' => null, # keep for backward compatibility
            'readonly' => false,

            'input_id_pref' => '',
            'input_name' => '',
            'input_data_atts' => [],
            'multiple' => false,
            'label' => __('Select', 'pboot'),
            'update_label' => true,
            'empty_name' => '',
            'selected' => '',
            'options' => [],

            'parent' => '',
            'parent_value' => '',
            'parent_enabled' => [],
            'data_atts' => [],
            'change_submit' => false
        ]);

        $this->setArgs();
        $this->setOptions();
        $this->setHtmlClass();
    }

    private function setArgs()
    {
        if(isset($this->args['enabled']))
        {
            $this->args['disabled'] = !$this->args['enabled'];
        }

        if(!$this->args['label'])
        {
            $this->args['label'] = $this->args['empty_name'];
        }
        if($this->args['parent'])
        {
            $this->args['data_atts']['data-parent'] = $this->args['parent'];
        }
        if($this->args['parent_enabled'])
        {
            $this->args['data_atts']['data-parent_enabled'] = implode(',', $this->args['parent_enabled']);
        }

        if(
            $this->args['parent'] && $this->args['parent_enabled'] 
            && (!$this->args['parent_value'] || !in_array($this->args['parent_value'], $this->args['parent_enabled']))
        ){
            $this->args['disabled'] = true;
        }

        if(!$this->args['options'])
        {
            $this->args['disabled'] = true;
        }
    }

    protected function setOptions()
    {
        $_options = [];

        foreach($this->args['options'] as $key => $option)
        {
            $_option = is_array($option) ? wp_parse_args($option, [
                'name' => '',
                'value' => '',
                'url' => '',
                'target' => '_self',
                'class' => ''
            ]) : [
                'name' => $option,
                'value' => $key,
                'url' => '',
                'target' => '_self',
                'class' => ''
            ];

            $_options[] = $_option;
        }

        $this->args['options'] = $_options;
    }

    private function setHtmlClass()
    {
        $this->addHtmlClass($this->get_input_name());
        $this->addHtmlClass('type-' . $this->getInputType());

        if($this->has_selected())
        {
            $this->addHtmlClass('has-selected');
        }

        if(isset($this->args['data_atts']['data-parent']))
        {
            $this->addHtmlClass('is-child');
        }

        if($this->args['disabled'])
        {
            $this->addHtmlClass("disabled");
        }
        if($this->args['readonly'])
        {
            $this->addHtmlClass("readonly");
        }
    }

    public function getDataAtts()
    {
        return $this->implodeAtts($this->args['data_atts']);
    }

    public function getInputDataAtts()
    {
        return $this->implodeAtts($this->args['input_data_atts']);
    }

    public function getInputType()
    {
        return $this->has_multiple() ? 'checkbox' : 'radio';
    }
}