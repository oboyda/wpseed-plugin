<?php

/*
Register plugin textdomain
----------------------------------------
*/
// add_action('init', 'pboot_load_textdomain');

// function pboot_load_textdomain()
// {
//     load_plugin_textdomain('pboot', false, plugin_basename(PBOOT_DIR) . '/languages');
// }

/*
Theme support
----------------------------------------
*/

add_action('after_setup_theme', 'pboot_add_theme_support');

function pboot_add_theme_support()
{
    add_theme_support('title-tag');
    
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(900, 600);

    add_theme_support(
        'custom-logo',
        array(
            'width'                => 300,
            'height'               => 100,
            'flex-width'           => true,
            'flex-height'          => true,
            'unlink-homepage-logo' => true
        )
    );

    add_theme_support('customize-selective-refresh-widgets');
}

/*
Register menus
----------------------------------------
*/

add_action('after_setup_theme', 'pboot_register_menus');

function pboot_register_menus()
{
    register_nav_menus(
        array(
            'top' => __('Top', 'pboot'),
            'primary' => __('Primary menu', 'pboot')
        )
    );
}

/*
Add image sizes
----------------------------------------
*/

add_action('after_setup_theme', 'pboot_add_image_sizes');

function pboot_add_image_sizes()
{
    add_image_size('medium', 800, 500, true);
    add_image_size('large', 1200, 750, true);
}
