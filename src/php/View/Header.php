<?php

namespace PBOOT\View;

use PBOOT\Utils\Settings as Utils_Settings;

class Header extends View 
{
    public function __construct($args)
    {
        parent::__construct($args, [

            'show_nav_top' => true,
            'show_nav_primary' => true,
            
            'logo_html' => $this->getCustomLogo(),
        ]);

        $this->_setHtmlClass();
    }

    protected function _setHtmlClass()
    {
        if($this->has_show_nav_top())
        {
            $this->addHtmlClass('has-nav-top');
        }
        if($this->has_show_nav_primary())
        {
            $this->addHtmlClass('has-nav-primary');
        }
    }

    protected function getCustomLogo()
    {
        $logo_url = Utils_Settings::getLogoUrl();
        return $logo_url ? $this->getImageHtml($logo_url, ['size' => 'full', 'rel_class' => 'rect-300-100', 'alt' => 'Logo']) : '';
    }
}
