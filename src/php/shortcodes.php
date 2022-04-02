<?php

/*
 * Add tiles-configurator shortcode
 * ----------------------------------------
 */

add_shortcode('tiles-configurator', 'tilec_shortcode_tiles_configurator');

function tilec_shortcode_tiles_configurator($atts)
{
    return '<div id="tilec-root"></div>';
}

// add_action('wp_enqueue_scripts', 'tilec_shortcode_tiles_configurator_scripts');

function tilec_shortcode_tiles_configurator_scripts()
{
    global $post;
    
    if(has_shortcode($post->post_content, 'tiles-configurator'))
    {
        wp_enqueue_script('tilec-react-app-main');
        wp_enqueue_style('tilec-react-app-main');
    }
}
