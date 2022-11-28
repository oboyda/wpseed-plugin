<?php

namespace PBOOT\Utils;

class Settings 
{
    static function getOption($name, $default=null)
    {
        $settings = $settings = new \WPSEED\Settings([
            'prefix' => 'pboot_',
            'render_fields' => false            
        ]);

        $opt = $settings->get_option($name);

        return (empty($opt) && isset($default)) ? $default : $opt;
    }

    static function getThemeOption($name, $default=null, $set_lang=true)
    {
        $lang = Base::getCurrentLanguage();

        if($set_lang)
        {
            $name .= '_' . $lang;
        }
        
        $option = get_theme_mod($name);

        return (empty($option) && isset($default)) ? $default : $option;
    }

    static function getLogoUrl()
    {
        $logo_id = (int)self::getThemeOption('custom_logo', 0, false);

        $image_src = $logo_id ? wp_get_attachment_image_src($logo_id, 'full') : [];
        return ($image_src && isset($image_src[0])) ? $image_src[0] : '';
    }
}
