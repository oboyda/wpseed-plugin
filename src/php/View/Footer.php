<?php

namespace PBOOT\View;

use PBOOT\Utils\Settings as Utils_Settings;
use PBOOT\Utils\Date as Utils_Date;

class Footer extends View 
{
    public function __construct($args)
    {
        parent::__construct($args, [

            'footer_info1' => Utils_Settings::getThemeOption('footer_info1'),
            'footer_info2' => Utils_Settings::getThemeOption('footer_info2'),
            'copy_info' => sprintf(__('&copy; %s %s. All rights reserved.', 'pboot'), date('Y'), get_bloginfo('name')),
            
            'logo_html' => $this->getCustomLogo()
        ]);

        $this->args['footer_info1'] = $this->replacePlaceholders($this->args['footer_info1']);
        $this->args['footer_info2'] = $this->replacePlaceholders($this->args['footer_info2']);
    }

    protected function replacePlaceholders($text)
    {
        $placeholders = [
            '%year%' => Utils_Date::getNowDate('Y')
        ];

        return !empty($text) ? str_replace(array_keys($placeholders), array_values($placeholders), $text) : $text;
    }

    public function getImplodedFooterInfo($sep=' | ')
    {
        $infos = [];
        if($this->has_footer_info1())
        {
            $infos[] = $this->get_footer_info1();
        }
        if($this->has_footer_info2())
        {
            $infos[] = $this->get_footer_info2();
        }
        return implode($sep, $infos);
    }

    protected function getCustomLogo()
    {
        $logo_url = Utils_Settings::getLogoUrl();
        return $logo_url ? $this->getImageHtml($logo_url, ['size' => 'full', 'rel_class' => 'rect-300-100', 'alt' => 'Logo']) : '';
    }
}
