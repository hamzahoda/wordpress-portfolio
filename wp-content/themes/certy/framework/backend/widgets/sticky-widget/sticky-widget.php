<?php
/**
 * The template for making sticky sidebar
 *
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'certy_sticky_widget_load_widgets' );

/**
 * Register our widget.
 */
function certy_sticky_widget_load_widgets() {
    register_widget( 'Certy_Sticky_Widget' );
}

/**
 * recent_Posts Widget class.
 */
class Certy_Sticky_Widget extends WP_Widget {

    /**
     * Widget setup.
     */
    function __construct() {
        /* Widget settings. */
        $widget_ops = array( 'classname' => 'certy_widget_sticky', 'description' => __('Makes the below widgets sticky','certy' ) );

        /* Widget control settings. */
        $control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'crt-sticky-widget' );

        /* Create the widget. */
        parent::__construct( 'crt-sticky-widget', __('Certy: Sticky Widget','certy' ), $widget_ops, $control_ops );
    }

    /**
     * How to display the widget on the screen.
     */
    function widget($args, $instance ) {
        extract( $args );

        if(is_active_widget(false, false, $this->id_base))
        {
            wp_enqueue_script('sticky-js', CERTY_BACKEND_URL . 'widgets/sticky-widget/assets/sticky-widget.js', array('jquery'), null, true);
            wp_enqueue_style( 'sticky-styles', CERTY_BACKEND_URL . 'widgets/sticky-widget/assets/sticky-widget.css', array(), null );
        }

        echo '<div id="wdg-sticky-start"></div>';
    }

}

?>