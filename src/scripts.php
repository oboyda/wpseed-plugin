<?php

/*
 * Register scripts
 * ----------------------------------------
 */
add_action('init', 'wppb_register_scripts');

function wppb_register_scripts()
{
    //wp_register_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js', [], null);
    //wp_register_script('vue', 'https://unpkg.com/vue@next', [], null);
    //wp_register_script('axios', 'https://unpkg.com/axios/dist/axios.min.js', [], null);
    //wp_register_script('qs', 'https://unpkg.com/qs/dist/qs.js', [], null);
}

/*
 * Register styles
 * ----------------------------------------
 */
add_action('init', 'wppb_register_styles');

function wppb_register_styles()
{
    wp_register_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css', [], null);
    wp_register_style('wppb-views', WPPB_INDEX . '/css/views.css', [], WPPB_VERSION);
}

/*
 * Enqueue scripts on admin
 * ----------------------------------------
 */
//add_action('admin_enqueue_scripts', 'wppb_enqueue_scripts_admin');

function wppb_enqueue_scripts_admin()
{
    //...
}

/*
 * Enqueue styles on admin
 * ----------------------------------------
 */
//add_action('admin_enqueue_scripts', 'wppb_enqueue_styles_admin');

function wppb_enqueue_styles_admin()
{
    //...
}

/*
 * Print ajaxurl global on front
 * ----------------------------------------
 */
//add_action('wp_head', 'wppb_print_ajax_url_global');

function wppb_print_ajax_url_global()
{
    ?>
    <script type="text/javascript">
        const ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    </script>
    <?php
}

/*
 * Enqueue scripts on front
 * ----------------------------------------
 */

add_action('wp_enqueue_scripts', 'wppb_enqueue_scripts');

function wppb_enqueue_scripts()
{
    //wp_enqueue_script('bootstrap');
    //wp_enqueue_script('jquery');
    //wp_enqueue_script('vue');
    //wp_enqueue_script('axios');
    //wp_enqueue_script('qs');
    //wp_localize_script('vue', 'vueVars', apply_filters('vue_vars', []));
}

/*
 * Enqueue styles on front
 * ----------------------------------------
 */

add_action('wp_enqueue_scripts', 'wppb_enqueue_styles');

function wppb_enqueue_styles()
{
    //wp_enqueue_style('bootstrap');
    wp_enqueue_style('wppb-views');
}
