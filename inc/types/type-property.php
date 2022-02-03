<?php

/*
* property post_type
* -------------------------
*/

add_action('init', 'hsp_add_post_type_property');

function hsp_add_post_type_property()
{
    $labels = [
        'name'               => _x('Properties', 'post type general name', 'hsp'),
        'singular_name'      => _x('Property', 'post type singular name', 'hsp'),
        'menu_name'          => _x('Properties', 'admin menu', 'hsp'),
        'name_admin_bar'     => _x('Properties', 'add new on admin bar', 'hsp'),
        'add_new'            => _x('Add property', 'property type', 'hsp'),
        'add_new_item'       => __('Add new property', 'hsp'),
        'new_item'           => __('New property', 'hsp'),
        'edit_item'          => __('Edit property', 'hsp'),
        'view_item'          => __('View property', 'hsp'),
        'all_items'          => __('All properties', 'hsp'),
        'search_items'       => __('Search properties', 'hsp'),
        'parent_item_colon'  => __('Property parent:', 'hsp'),
        'not_found'          => __('No properties found.', 'hsp'),
        'not_found_in_trash' => __('No properties found in trash.', 'hsp')
    ];
    $args = [
        'labels'              => $labels,
        'description'         => __('Property post type.', 'hsp'),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => _x('property', 'URL slug', 'hsp')),
        'capability_category' => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 56,
        'menu_icon'           => 'dashicons-building',
        'supports'            => array('title', 'editor', 'thumbnail')
    ];
    register_post_type('property', $args);

    register_taxonomy('property_type', 'property', array(
        'labels'                => array(
            'name'              => _x('Types', 'taxonomy general name', 'hsp'),
            'singular_name'     => _x('Type', 'taxonomy singular name', 'hsp'),
            'search_items'      => __('Search types', 'hsp'),
            'all_items'         => __('All types', 'hsp'),
            'parent_item'       => __('Parent type', 'hsp'),
            'parent_item_colon' => __('Parent type:', 'hsp'),
            'edit_item'         => __('Edit type', 'hsp'),
            'update_item'       => __('Update type', 'hsp'),
            'add_new_item'      => __('Add new type', 'hsp'),
            'new_item_name'     => __('New type', 'hsp'),
            'menu_name'         => __('Types', 'hsp'),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'property-type')
    ));

    register_taxonomy('property_feature', 'property', array(
        'labels'                => array(
            'name'              => _x('Features', 'taxonomy general name', 'hsp'),
            'singular_name'     => _x('Feature', 'taxonomy singular name', 'hsp'),
            'search_items'      => __('Search features', 'hsp'),
            'all_items'         => __('All features', 'hsp'),
            'parent_item'       => __('Parent feature', 'hsp'),
            'parent_item_colon' => __('Parent feature:', 'hsp'),
            'edit_item'         => __('Edit feature', 'hsp'),
            'update_item'       => __('Update feature', 'hsp'),
            'add_new_item'      => __('Add new feature', 'hsp'),
            'new_item_name'     => __('New feature', 'hsp'),
            'menu_name'         => __('Features', 'hsp'),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'property-feature')
    ));

    register_taxonomy('property_condition', 'property', array(
        'labels'                => array(
            'name'              => _x('Conditions', 'taxonomy general name', 'hsp'),
            'singular_name'     => _x('Condition', 'taxonomy singular name', 'hsp'),
            'search_items'      => __('Search conditions', 'hsp'),
            'all_items'         => __('All conditions', 'hsp'),
            'parent_item'       => __('Parent condition', 'hsp'),
            'parent_item_colon' => __('Parent condition:', 'hsp'),
            'edit_item'         => __('Edit condition', 'hsp'),
            'update_item'       => __('Update condition', 'hsp'),
            'add_new_item'      => __('Add new condition', 'hsp'),
            'new_item_name'     => __('New condition', 'hsp'),
            'menu_name'         => __('Conditions', 'hsp'),
        ),
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'property-condition')
    ));

    register_taxonomy('branch', 'property', array(
        'labels'                => array(
            'name'              => _x('Branches', 'taxonomy general name', 'hsp'),
            'singular_name'     => _x('Branch', 'taxonomy singular name', 'hsp'),
            'search_items'      => __('Search branches', 'hsp'),
            'all_items'         => __('All branches', 'hsp'),
            'parent_item'       => __('Parent branch', 'hsp'),
            'parent_item_colon' => __('Parent branch:', 'hsp'),
            'edit_item'         => __('Edit branch', 'hsp'),
            'update_item'       => __('Update branch', 'hsp'),
            'add_new_item'      => __('Add new branch', 'hsp'),
            'new_item_name'     => __('New branch', 'hsp'),
            'menu_name'         => __('Branches', 'hsp'),
        ),
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'branch')
    ));

    register_taxonomy('country', 'property', array(
        'labels'                => array(
            'name'              => _x('Countries', 'taxonomy general name', 'hsp'),
            'singular_name'     => _x('Country', 'taxonomy singular name', 'hsp'),
            'search_items'      => __('Search countries', 'hsp'),
            'all_items'         => __('All countries', 'hsp'),
            'parent_item'       => __('Parent country', 'hsp'),
            'parent_item_colon' => __('Parent country:', 'hsp'),
            'edit_item'         => __('Edit country', 'hsp'),
            'update_item'       => __('Update country', 'hsp'),
            'add_new_item'      => __('Add new country', 'hsp'),
            'new_item_name'     => __('New country', 'hsp'),
            'menu_name'         => __('Countries', 'hsp'),
        ),
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'country')
    ));

    register_taxonomy('state', 'property', array(
        'labels'                => array(
            'name'              => _x('States', 'taxonomy general name', 'hsp'),
            'singular_name'     => _x('State', 'taxonomy singular name', 'hsp'),
            'search_items'      => __('Search states', 'hsp'),
            'all_items'         => __('All states', 'hsp'),
            'parent_item'       => __('Parent state', 'hsp'),
            'parent_item_colon' => __('Parent state:', 'hsp'),
            'edit_item'         => __('Edit state', 'hsp'),
            'update_item'       => __('Update state', 'hsp'),
            'add_new_item'      => __('Add new state', 'hsp'),
            'new_item_name'     => __('New state', 'hsp'),
            'menu_name'         => __('States', 'hsp'),
        ),
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'state')
    ));

    register_taxonomy('city', 'property', array(
        'labels'                => array(
            'name'              => _x('Cities', 'taxonomy general name', 'hsp'),
            'singular_name'     => _x('City', 'taxonomy singular name', 'hsp'),
            'search_items'      => __('Search cities', 'hsp'),
            'all_items'         => __('All cities', 'hsp'),
            'parent_item'       => __('Parent city', 'hsp'),
            'parent_item_colon' => __('Parent city:', 'hsp'),
            'edit_item'         => __('Edit city', 'hsp'),
            'update_item'       => __('Update city', 'hsp'),
            'add_new_item'      => __('Add new city', 'hsp'),
            'new_item_name'     => __('New city', 'hsp'),
            'menu_name'         => __('Cities', 'hsp'),
        ),
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'city')
    ));

    register_taxonomy('parish', 'property', array(
        'labels'                => array(
            'name'              => _x('Parishes', 'taxonomy general name', 'hsp'),
            'singular_name'     => _x('Parish', 'taxonomy singular name', 'hsp'),
            'search_items'      => __('Search parishes', 'hsp'),
            'all_items'         => __('All parishes', 'hsp'),
            'parent_item'       => __('Parent parish', 'hsp'),
            'parent_item_colon' => __('Parent parish:', 'hsp'),
            'edit_item'         => __('Edit parish', 'hsp'),
            'update_item'       => __('Update parish', 'hsp'),
            'add_new_item'      => __('Add new parish', 'hsp'),
            'new_item_name'     => __('New parish', 'hsp'),
            'menu_name'         => __('Parishes', 'hsp'),
        ),
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'parish')
    ));

    register_taxonomy('zone', 'property', array(
        'labels'                => array(
            'name'              => _x('Zones', 'taxonomy general name', 'hsp'),
            'singular_name'     => _x('Zone', 'taxonomy singular name', 'hsp'),
            'search_items'      => __('Search zones', 'hsp'),
            'all_items'         => __('All zones', 'hsp'),
            'parent_item'       => __('Parent zone', 'hsp'),
            'parent_item_colon' => __('Parent zone:', 'hsp'),
            'edit_item'         => __('Edit zone', 'hsp'),
            'update_item'       => __('Update zone', 'hsp'),
            'add_new_item'      => __('Add new zone', 'hsp'),
            'new_item_name'     => __('New zone', 'hsp'),
            'menu_name'         => __('Zones', 'hsp'),
        ),
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'zone')
    ));
}
