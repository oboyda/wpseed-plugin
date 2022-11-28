<?php

namespace PBOOT\Mod\Action_Email\Type\Reg;

class Email 
{
    public function __construct()
    {
        add_action('init', __CLASS__ . '::registerType');
    }

    static function registerType()
    {
        $labels = [
            'name'               => _x('Action Emails', 'post type general name', 'pboot'),
            'singular_name'      => _x('Action Email', 'post type singular name', 'pboot'),
            'menu_name'          => _x('Action Emails', 'admin menu', 'pboot'),
            'name_admin_bar'     => _x('Action Emails', 'add new on admin bar', 'pboot'),
            'add_new'            => _x('Add action email', 'action email type', 'pboot'),
            'add_new_item'       => __('Add new action email', 'pboot'),
            'new_item'           => __('New action email', 'pboot'),
            'edit_item'          => __('Edit action email', 'pboot'),
            'view_item'          => __('View action email', 'pboot'),
            'all_items'          => __('All action emails', 'pboot'),
            'search_items'       => __('Search action emails', 'pboot'),
            'parent_item_colon'  => __('Action Email parent:', 'pboot'),
            'not_found'          => __('No action emails found.', 'pboot'),
            'not_found_in_trash' => __('No action emails found in trash.', 'pboot')
        ];
        $args = [
            'labels'              => $labels,
            'description'         => __('Action Email post type.', 'pboot'),
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'query_var'           => true,
            'rewrite'             => array('slug' => _x('action-email', 'URL slug', 'pboot')),
            'capability_category' => 'post',
            'has_archive'         => true,
            'hierarchical'        => false,
            'menu_position'       => 56,
            'menu_icon'           => 'dashicons-email',
            'supports'            => array('title', 'editor')
        ];

        register_post_type('action_email', $args);
    }
}
