<?php

namespace PBOOT\Mod\Form_Advanced\View;

class Form_Nice_Checkbox extends \PBOOT\View\View 
{
    const MOD_NAME = 'Form_Advanced';

    public function __construct($args, $args_default=[])
    {
        parent::__construct($args, wp_parse_args($args_default, [

            'disabled' => false,
            'enabled' => null, # keep for backward compatibility
            'readonly' => false,

            'title' => '',
            'input_id_pref' => '',
            'input_name' => '',
            'multiple' => false,
            'update_label' => true,
            'selected' => '',
            'options' => [
                // [
                //     'name' => '',
                //     'value' => '',
                //     'icon_html' => '',
                //     'icon_class' => ''
                // ]
            ],
            'inline' => false,
            'checkbox_pos' => 'left',
            'size' => 'normal', #normal, large,
            'required' => false,

            'parent' => '',
            'parent_value' => '',
            'parent_enabled' => [],
            'data_atts' => [],
            'change_submit' => false,

            'input_type' => null
        ]));

        if(empty($args_default))
        {
            $this->setArgs();
            $this->setOptions();
            $this->setHtmlClass();
        }
    }

    private function setArgs()
    {
        if(isset($this->args['enabled']))
        {
            $this->args['disabled'] = !$this->args['enabled'];
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

        // if(!$this->args['options'])
        // {
        //     $this->args['disabled'] = true;
        // }

        if(!is_array($this->args['selected']))
        {
            $this->args['selected'] = [$this->args['selected']];
        }

        if(!isset($this->args['input_type']))
        {
            $this->args['input_type'] = $this->args['multiple'] ? 'checkbox' : 'radio';
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
                'icon_html' => '',
                'icon_class' => ''
            ]) : [
                'name' => $option,
                'value' => $key,
                'icon_html' => '',
                'icon_class' => ''
            ];

            $_options[] = $_option;
        }

        $this->args['options'] = $_options;
    }

    private function setHtmlClass()
    {
        $this->addHtmlClass($this->get_input_name());
        
        $this->addHtmlClass('type-' . $this->args['input_type']);

        if($this->has_selected())
        {
            $this->addHtmlClass('has-selected');
        }

        if(isset($this->args['data_atts']['data-parent']))
        {
            $this->addHtmlClass('is-child');
        }

        if($this->args['inline'])
        {
            $this->addHtmlClass("opts-inline");
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

    public function getOptionsNum()
    {
        return is_array($this->args['options']) ? count($this->args['options']) : 0;
    }
}