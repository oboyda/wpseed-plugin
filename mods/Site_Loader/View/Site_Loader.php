<?php

namespace PBOOT\Mod\Site_Loader\View;

class Site_Loader extends \PBOOT\View\View 
{
    CONST MOD_NAME = 'Site_Loader';

    public function __construct($args)
    {
        parent::__construct($args, [
            'pos' => '', #full
            'shadow' => '', #light, dark,
            'bootstrap_type' => 'spinner-grow'
        ]);

        $this->_setHtmlClass();
    }

    protected function _setHtmlClass()
    {
        if($this->args['pos'])
        {
            $this->addHtmlClass('pos-' . $this->args['pos']);
        }
        if($this->args['shadow'])
        {
            $this->addHtmlClass('shadow-' . $this->args['shadow']);
        }
    }
}