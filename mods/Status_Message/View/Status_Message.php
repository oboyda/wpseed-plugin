<?php

namespace PBOOT\Mod\Status_Message\View;

class Status_Message extends \PBOOT\View\View 
{
    public function __construct($args)
    {
        parent::__construct($args, [
            
            'type' => 'success',
            'icon_class' => '',
            'show_icon' => true,
            // 'show_icon_sep' => true,
            'message' => '',
            'size' => 'normal'
        ]);

        $this->setIconClass();
        $this->_setHtmlClass();
    }

    public function setIconClass()
    {
        if(empty($this->args['icon_class']))
        {
            switch($this->args['type'])
            {
                case 'success':
                    $this->args['icon_class'] = 'bi bi-check-circle';
                break;
                case 'warning':
                    $this->args['icon_class'] = 'bi bi-exclamation-circle';
                break;
                case 'error':
                    $this->args['icon_class'] = 'bi bi-x-circle';
                break;
                case 'info':
                    $this->args['icon_class'] = 'bi bi-info-circle';
                break;
            }
        }
    }

    protected function _setHtmlClass()
    {
        $this->addHtmlClass('type-' . $this->args['type']);
        $this->addHtmlClass('size-' . $this->args['size']);

        if($this->args['show_icon'])
        {
            $this->addHtmlClass('has-icon');
        }
        // if($this->args['show_icon_sep'])
        // {
        //     $this->addHtmlClass('has-icon-sep');
        // }
    }
}