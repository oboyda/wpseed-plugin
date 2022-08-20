<?php

namespace WPPBOOT;

class Deps
{
    protected $deps;
    var $notices;
    
    public function __construct($deps=[])
    {
        $this->deps = $deps;
        $this->notices = [];
        
        add_action('admin_notices', [$this, 'printNotices']);
    }
    
    public function check()
    {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');

        $check = true;

        foreach($this->deps as $dep)
        {
            if(!is_plugin_active($dep))
            {
                $check = false;

                $notice  = '<div class="notice notice-warning is-dismissible">';
                    $notice .= '<p>' . sprintf(__('%s requires %s to work properly.', 'wppboot'), WPPBOOT_NAME, $dep) . '</p>';
                $notice .= '</div>';
                
                $this->notices[] = $notice;
            }
        }

        return $check;
    }
    
    public function printNotices()
    {
        if(!empty($this->notices))
        {
            echo implode(PHP_EOL, $this->notices);
        }
    }
}
