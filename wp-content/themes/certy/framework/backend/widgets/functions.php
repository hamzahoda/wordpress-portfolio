<?php
/**
 * Certy admin functions
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

/**
 * Register Certy widget areas.
 *
 */
function certy_widgets_init() {

    register_sidebar( array(
        'name'          => esc_html__( 'Main Left Sidebar 1', 'certy' ),
        'id'            => 'left-sidebar-1',
        'description'   => esc_html__( 'Main sidebar that appears on the left.', 'certy' ),
        'before_widget' => '<aside class="widget clearfix %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Main Left Sidebar 2', 'certy' ),
        'id'            => 'left-sidebar-2',
        'description'   => esc_html__( 'Main sidebar that appears on the left.', 'certy' ),
        'before_widget' => '<aside class="widget clearfix %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Secondary Left Sidebar 1', 'certy' ),
        'id'            => 'other-left-sidebar-1',
        'description'   => esc_html__( 'This sidebar will override the "Main Left Sidebar 1" on all pages different from home.', 'certy' ),
        'before_widget' => '<aside class="widget clearfix %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Secondary Left Sidebar 2', 'certy' ),
        'id'            => 'other-left-sidebar-2',
        'description'   => esc_html__( 'This sidebar will override the "Main Left Sidebar 2" on all pages different from home.', 'certy' ),
        'before_widget' => '<aside class="widget clearfix %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Right Sidebar', 'certy' ),
        'id'            => 'right-sidebar',
        'description'   => esc_html__( 'Main sidebar that appears on the left.', 'certy' ),
        'before_widget' => '<section class="widget clearfix %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Right Sidebar For Pages', 'certy' ),
        'id'            => 'right-sidebar-pages',
        'description'   => esc_html__( 'This sidebar will override the main "Right Sidebar" on all pages', 'certy' ),
        'before_widget' => '<aside class="widget clearfix %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Right Sidebar For Archive Pages', 'certy' ),
        'id'            => 'right-sidebar-archives',
        'description'   => esc_html__( 'This sidebar will override the main "Right Sidebar" on all archive pages(category, archive, tag, etc)', 'certy' ),
        'before_widget' => '<aside class="widget clearfix %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Right Sidebar For Single Post', 'certy' ),
        'id'            => 'right-sidebar-single',
        'description'   => esc_html__( 'This sidebar will override the main "Right Sidebar" on single post', 'certy' ),
        'before_widget' => '<aside class="widget clearfix %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'certy_widgets_init' );

/**
 * Register Certy custom widgets.
 *
 */

/**
 * Card Widget
 */
require_once( CERTY_BACKEND_PATH . 'widgets/card.php' );

/**
 * Recent Posts Widget
 */
require_once( CERTY_BACKEND_PATH . 'widgets/recent-posts.php' );

/**
 * Instagram Widget
 */
require_once( CERTY_BACKEND_PATH . 'widgets/instagram-widget.php' );

/**
 * Sticky Widget
 */
require_once( CERTY_BACKEND_PATH . 'widgets/sticky-widget/sticky-widget.php' );