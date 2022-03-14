<?php

/*
 * Auto include files in inc/ directory
 */
foreach(wpseed_get_dir_files(dirname(__FILE__), true, false) as $dir_file)
{
    if(is_dir($dir_file))
    {
        $inc_file = $dir_file . '/inc.php';
        if(file_exists($inc_file))
        {
            require_once $inc_file;
        }
    }
}
