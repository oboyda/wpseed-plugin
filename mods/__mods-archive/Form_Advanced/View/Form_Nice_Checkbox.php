<?php

namespace PBOOT\Mod\Form_Advanced\View;

class Form_Nice_Checkbox extends \PBOOT\View\View 
{
    public function __construct($args)
    {
        parent::__construct($args, [

            'title' => '',
            'enabled' => true,
            'input_name' => '',
            'multiple' => false,
            'update_label' => true,
            'selected' => '',
            'options' => [],
            'inline' => false,
            'size' => 'normal', #normal, large,
            'required' => false,

            'parent' => '',
            'parent_value' => '',
            'parent_enabled' => [],
            'data_atts' => [],
            'change_submit' => false
        ]);

        $this->setArgs();
        $this->setOptions();
        $this->_setHtmlClass();
    }

    protected function setArgs()
    {
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
            $this->args['enabled'] = false;
        }

        if(!$this->args['options'])
        {
            $this->args['enabled'] = false;
        }

        if(!is_array($this->args['selected']))
        {
            $this->args['selected'] = [$this->args['selected']];
        }
    }

    protected function setOptions()
    {
        $_options = [];

        foreach($this->args['options'] as $key => $option)
        {
            $_option = is_array($option) ? wp_parse_args($option, [
                'name' => '',
                'value' => ''
            ]) : [
                'name' => $option,
                'value' => $key
            ];

            $_options[] = $_option;
        }

        $this->args['options'] = $_options;
    }

    protected function _setHtmlClass()
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

        if(!$this->args['enabled'])
        {
            $this->addHtmlClass("disabled");
        }

        if($this->args['inline'])
        {
            $this->addHtmlClass("opts-inline");
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
