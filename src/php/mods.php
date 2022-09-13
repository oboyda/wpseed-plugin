<?php 

/*
* Include modules
* ----------------------------------------
*/

foreach(wpseed_get_dir_files(PBOOT_DIR . '/mods', true, false) as $dir)
{
    $mod_index_file = $dir . '/index.php';
    if(file_exists($mod_index_file))
    {
        require_once $mod_index_file;
    }
}
