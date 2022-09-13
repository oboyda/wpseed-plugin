<?php

namespace PBOOT\Mod\Business_Register\Type\Reg;

class Business 
{
    public function __construct()
    {
        add_action('init', __CLASS__ . '::register_type');
    }

    static function register_type()
    {
        $labels = [
            'name'               => _x('Businesses', 'post type general name', 'pboot'),
            'singular_name'      => _x('Business', 'post type singular name', 'pboot'),
            'menu_name'          => _x('Businesses', 'admin menu', 'pboot'),
            'name_admin_bar'     => _x('Businesses', 'add new on admin bar', 'pboot'),
            'add_new'            => _x('Add business', 'business type', 'pboot'),
            'add_new_item'       => __('Add new business', 'pboot'),
            'new_item'           => __('New business', 'pboot'),
            'edit_item'          => __('Edit business', 'pboot'),
            'view_item'          => __('View business', 'pboot'),
            'all_items'          => __('All businesses', 'pboot'),
            'search_items'       => __('Search businesses', 'pboot'),
            'parent_item_colon'  => __('Business parent:', 'pboot'),
            'not_found'          => __('No businesses found.', 'pboot'),
            'not_found_in_trash' => __('No businesses found in trash.', 'pboot')
        ];
        $args = [
            'labels'              => $labels,
            'description'         => __('Business post type.', 'pboot'),
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'query_var'           => true,
            'rewrite'             => array('slug' => _x('business', 'URL slug', 'pboot')),
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
