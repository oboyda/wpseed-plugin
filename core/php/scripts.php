<?php

/*
Register scripts
----------------------------------------
*/
add_action('wp_enqueue_scripts', 'pboot_register_scripts');
add_action('admin_enqueue_scripts', 'pboot_register_styles');

function pboot_register_scripts()
{
    $asset_file = PBOOT_DIR . '/build/front.asset.php';
    if(file_exists($asset_file))
    {
        $asset = include($asset_file);

        wp_register_script(
            'pboot-front',
            PBOOT_INDEX . '/build/front.js',
            array_merge($asset['dependencies'], [
                // 'jquery-ui-datepicker'
            ]),
            $asset['version'],
            true
        );
    }

    $asset_file = PBOOT_DIR . '/build/admin.asset.php';
    if(file_exists($asset_file))
    {
        $asset = include($asset_file);

        wp_register_script(
            'pboot-admin',
            PBOOT_INDEX . '/build/admin.js',
            $asset['dependencies'],
            $asset['version'],
            true
        );
    }
}

/*
Register styles
----------------------------------------
*/
add_action('wp_enqueue_scripts', 'pboot_register_styles');
add_action('admin_enqueue_scripts', 'pboot_register_styles');

function pboot_register_styles()
{
    // wp_register_style(
    //     'bootstrap-grid',
    //     PBOOT_INDEX . '/assets/bootstrap/css/bootstrap-grid.min.css',
    //     [],
    //     PBOOT_VERSION
    // );
    // wp_register_style(
    //     'bootstrap',
    //     PBOOT_INDEX . '/assets/bootstrap/css/bootstrap.min.css',
    //     [],
    //     PBOOT_VERSION
    // );
    wp_register_style(
        'pboot-fonts',
        PBOOT_INDEX . '/assets/fonts/fonts.css',
        [],
        PBOOT_VERSION
    );
    // wp_register_style(
    //     'jquery-ui-style',
    //     PBOOT_INDEX . '/assets/jquery-ui/css/jquery-ui.min.css',
    //     [],
    //     PBOOT_VERSION
    // );

    $asset_file = PBOOT_DIR . '/build/front.asset.php';
    if(file_exists($asset_file))
    {
        $asset = include($asset_file);

        wp_register_style(
            'pboot-front',
            PBOOT_INDEX . '/build/front.css',
            // $asset['dependencies'],
            [
                // 'bootstrap',
                'dashicons',
                // 'jquery-ui-style'
            ],
            $asset['version']
        );
    }

    $asset_file = PBOOT_DIR . '/build/admin.asset.php';
    if(file_exists($asset_file))
    {
        $asset = include($asset_file);

        wp_register_style(
            'pboot-admin',
            PBOOT_INDEX . '/build/admin.css',
            // $asset['dependencies'],
            [
                // 'bootstrap-grid',
                'dashicons',
                // 'jquery-ui-style'
            ],
            $asset['version']
        );
    }
}

/*
Enqueue scripts on FRONT
----------------------------------------
*/
add_action('wp_enqueue_scripts', 'pboot_enqueue_scripts_front');

function pboot_enqueue_scripts_front()
{
    wp_enqueue_script('pboot-front');
    wp_localize_script('pboot-front', 'pbootIndexVars', apply_filters('pboot_js_index_vars', [
        'ajaxurl' => admin_url('admin-ajax.php')
    ]));
}

/*
Enqueue scripts on ADMIN
----------------------------------------
*/
add_action('admin_enqueue_scripts', 'pboot_enqueue_scripts_admin');

function pboot_enqueue_scripts_admin()
{
    wp_enqueue_script('pboot-admin');
    wp_localize_script('pboot-admin', 'pbootIndexVars', apply_filters('pboot_js_index_vars', [
        'ajaxurl' => admin_url('admin-ajax.php')
    ]));
}

/*
Enqueue styles on FRONT
----------------------------------------
*/
add_action('wp_enqueue_scripts', 'pboot_enqueue_styles_front');

function pboot_enqueue_styles_front()
{
    wp_enqueue_style('pboot-fonts');
    wp_enqueue_style('pboot-front');
}

/*
Enqueue styles on ADMIN
----------------------------------------
*/
add_action('admin_enqueue_scripts', 'pboot_enqueue_styles_admin');

function pboot_enqueue_styles_admin()
{
    wp_enqueue_style('pboot-admin');
}
