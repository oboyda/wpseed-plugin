<?php

namespace PBOOT\Utils;

class Settings 
{
    static function getOption($name, $default=null)
    {
        global $pboot_setup;
        return $pboot_setup->settings->getOption($name, $default);
    }

    static function getThemeOption($name, $default=null, $set_lang=true)
    {
        global $pboot_setup;
        return $pboot_setup->settings->getThemeOption($name, $default, $set_lang);
    }

    static function getLogoUrl()
    {
        $logo_id = (int)self::getThemeOption('custom_logo', 0, false);

        $image_src = $logo_id ? wp_get_attachment_image_src($logo_id, 'full') : [];
        return ($image_src && isset($image_src[0])) ? $image_src[0] : '';
    }
}
