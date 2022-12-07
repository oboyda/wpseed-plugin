<?php

/*
* Register Gutenberg blocks with ACF
* ----------------------------------------
*/

add_action('acf/init', 'pboot_register_blocks');

function pboot_register_blocks()
{
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
            'render_callback'	=> 'pboot_render_block_view',
            'category'			=> 'pboot-blocks',
            //'icon'				=> 'admin-comments'
            //'keywords'			=> [''],
            'view_args' => [],
            'mode' => 'auto'
        ]);
    }
}

/*
* Register callback wrapper function
* ----------------------------------------
*/
function pboot_render_block_view($block, $content, $is_preview, $post_id, $wp_block, $context)
{
    $acf_prefix = 'acf/';

    $view = (strpos($block['name'], $acf_prefix) === 0) ? substr($block['name'], strlen($acf_prefix)) : $block['name'];
    $view_args = isset($block['view_args']) ? $block['view_args'] : [];

    // $view_args['block_id'] = isset($block['id']) ? $block['id'] : '';
    $view_args['block_id'] = \WPSEEDE\Utils\Base::getBlockId($wp_block);
    $view_args['data'] = isset($block['data']) ? $block['data'] : '';

    $view_args['html_class'] = isset($block['className']) ? $block['className'] : '';

    echo pboot_get_view($view, $view_args);
}
