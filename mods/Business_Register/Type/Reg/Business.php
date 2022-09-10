<?php

namespace WPPBOOT\Mod\Business_Register\Type\Reg;

class Business 
{
    public function __construct()
    {
        add_action('init', __CLASS__ . '::register_type');
    }

    static function register_type()
    {
        $labels = [
            'name'               => _x('Businesses', 'post type general name', 'wppboot'),
            'singular_name'      => _x('Business', 'post type singular name', 'wppboot'),
            'menu_name'          => _x('Businesses', 'admin menu', 'wppboot'),
            'name_admin_bar'     => _x('Businesses', 'add new on admin bar', 'wppboot'),
            'add_new'            => _x('Add business', 'business type', 'wppboot'),
            'add_new_item'       => __('Add new business', 'wppboot'),
            'new_item'           => __('New business', 'wppboot'),
            'edit_item'          => __('Edit business', 'wppboot'),
            'view_item'          => __('View business', 'wppboot'),
            'all_items'          => __('All businesses', 'wppboot'),
            'search_items'       => __('Search businesses', 'wppboot'),
            'parent_item_colon'  => __('Business parent:', 'wppboot'),
            'not_found'          => __('No businesses found.', 'wppboot'),
            'not_found_in_trash' => __('No businesses found in trash.', 'wppboot')
        ];
        $args = [
            'labels'              => $labels,
            'description'         => __('Business post type.', 'wppboot'),
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'query_var'           => true,
            'rewrite'             => array('slug' => _x('business', 'URL slug', 'wppboot')),
            'capability_category' => 'post',
            'has_archive'         => true,
            'hierarchical'        => false,
            'menu_position'       => 56,
            'menu_icon'           => 'dashicons-building',
            'supports'            => array('title', 'thumbnail')
        ];

        register_post_type('business', $args);
    }
}
