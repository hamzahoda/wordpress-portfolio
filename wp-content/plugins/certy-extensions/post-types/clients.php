<?php
/**
 * certy-extensions
 *
 * @package certy-extensions
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

if ( ! function_exists('certy_clients') ) {

// Register Custom Post Type
    function certy_clients() {

        $labels = array(
            'name'                  => _x( 'Clients Items', 'Post Type General Name', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'singular_name'         => _x( 'Clients', 'Post Type Singular Name', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'menu_name'             => __( 'Clients', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'name_admin_bar'        => __( 'Clients', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'archives'              => __( 'Clients Archives', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'attributes'            => __( 'Clients Attributes', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'parent_item_colon'     => __( 'Parent Item:', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'all_items'             => __( 'All Items', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'add_new_item'          => __( 'Add New Item', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'add_new'               => __( 'Add New', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'new_item'              => __( 'New Item', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'edit_item'             => __( 'Edit Item', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'update_item'           => __( 'Update Item', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'view_item'             => __( 'View Item', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'view_items'            => __( 'View Items', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'search_items'          => __( 'Search Item', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'not_found'             => __( 'Not found', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'not_found_in_trash'    => __( 'Not found in Trash', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'featured_image'        => __( 'Featured Image', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'set_featured_image'    => __( 'Set featured image', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'remove_featured_image' => __( 'Remove featured image', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'use_featured_image'    => __( 'Use as featured image', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'insert_into_item'      => __( 'Insert into item', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'items_list'            => __( 'Items list', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'items_list_navigation' => __( 'Items list navigation', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'filter_items_list'     => __( 'Filter items list', CERTY_EXTENSIONS_TEXT_DOMAIN ),
        );
        $args = array(
            'label'                 => __( 'Clients', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'description'           => __( 'Clients Post Type For Certy Theme', CERTY_EXTENSIONS_TEXT_DOMAIN ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'thumbnail', ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-universal-access-alt',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
        );
        register_post_type( 'certy_clients', $args );

    }
    add_action( 'init', 'certy_clients', 0 );

}