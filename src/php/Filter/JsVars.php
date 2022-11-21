<?php 

namespace PBOOT\Filter;

use PBOOT\Utils\Settings as Utils_Settings;

class JsVars 
{
    public function __construct()
    {
        // add_filter('pboot_js_index_vars', [$this, 'addGoogleMapsKey']);
    }

    public function addGoogleMapsKey($js_vars)
    {
        $js_vars['googlemaps_api_key'] = Utils_Settings::getOption('googlemaps_api_key');

        return $js_vars;
    }
}