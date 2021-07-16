<?php

function wppb_debug_pre($var)
{
    echo '<pre>';
        print_r($var);
    echo '</pre>';
}

function wppb_debug($var, $append=false, $file_name='__debug.txt')
{
    $file_path = ABSPATH . '/' . $file_name;
    
    if(is_array($var) || is_object($var))
    {
        if($append)
        {
            file_put_contents($file_path, print_r($var, true), FILE_APPEND);
        }
        else
        {
            file_put_contents($file_path, print_r($var, true));
        }
    }
    else
    {
        if($append)
        {
            file_put_contents($file_path, $var, FILE_APPEND);
        }
        else
        {
            file_put_contents($file_path, $var);
        }
    }
}

if(!function_exists('wppb_check_deps'))
{
    /*
     * Check plugin dependencies
     * 
     * @return bool
     */
    function wppb_check_deps($deps)
    {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        
        $deps_ok = true;

        foreach($deps as $dep)
        {
            if(!is_plugin_active($dep))
            {
                $deps_ok = false;

                if(is_admin())
                {
                    add_action('admin_notices', function(){
                    ?>
                        <div class="notice notice-warning is-dismissible">
                            <p><?php printf(__('%s requires %s to work properly.', 'wppb'), WPPB_NAME, $dep); ?></p>
                        </div>
                    <?php
                    });
                }
            }
        }

        return $deps_ok;
    }
}