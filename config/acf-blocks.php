<?php

/*
* Register Gutenberg blocks with ACF
* ----------------------------------------
*/

add_action('acf/init', 'pboot_register_blocks');

function pboot_register_blocks()
{
    global $pboot_setup;
    
    if(function_exists('acf_register_block'))
    {
        /*
        * test-block
        * ------------------------------
        */
        acf_register_block([
            'name'				=> 'test-block',
            'title'				=> __('PBOOT Test Block', 'pboot'),
            //'description'		=> __('Block description.', 'pboot'),
            'render_callback'	=> isset($pboot_setup) ? [$pboot_setup->view_loader, 'renderViewAcf'] : false,
            'category'			=> 'pboot-blocks',
            //'icon'				=> 'admin-comments'
            //'keywords'			=> [''],
            'view_args' => [],
            'mode' => 'auto'
        ]);
    }
}
