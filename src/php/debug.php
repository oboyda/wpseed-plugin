<?php

/*
 * Simple debug function with pre output
 */
function pboot_debug_pre($var)
{
    echo '<pre>';
        print_r($var);
    echo '</pre>';
}

/*
 * Simple debug function
 */
function pboot_debug($var, $append=false, $file_name='__debug.txt')
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
