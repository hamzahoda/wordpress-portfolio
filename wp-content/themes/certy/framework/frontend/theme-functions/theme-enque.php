<?php
/**
 * Certy frontend functions
 *
 * @package CERTY_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

/**
 * Enqueue styles.
 */
function certy_styles() {
    $typography_options = certy_typography_options(true);
    
    // Google fonts
    wp_enqueue_style( $typography_options['main_font_family'], "https://fonts.googleapis.com/css?family={$typography_options['main_font_family']}:400,700", array() );
    if($typography_options['heading_font_family'] != $typography_options['main_font_family']){
        wp_enqueue_style( $typography_options['heading_font_family'], "https://fonts.googleapis.com/css?family={$typography_options['heading_font_family']}:400,700", array() );
    }
    if($typography_options['logo_font_family'] != $typography_options['main_font_family'] && $typography_options['logo_font_family'] != $typography_options['heading_font_family']){
        wp_enqueue_style( $typography_options['logo_font_family'], "https://fonts.googleapis.com/css?family={$typography_options['logo_font_family']}", array() );
    }
    if($typography_options['button_font_family'] != $typography_options['main_font_family'] && $typography_options['button_font_family'] != $typography_options['heading_font_family']  && $typography_options['button_font_family'] != $typography_options['logo_font_family']){
        wp_enqueue_style( $typography_options['button_font_family'], "https://fonts.googleapis.com/css?family={$typography_options['button_font_family']}", array() );
    }


    // Icon fonts
    wp_enqueue_style( 'icon-fonts', get_template_directory_uri() . '/assets/fonts/icomoon/style.css', array(), null );

    // plugin styles
    wp_enqueue_style( 'plugin-styles', get_template_directory_uri() . '/assets/css/plugins.min.css', array(), null );

    // Enqueue stylesheet
    wp_enqueue_style( 'certy-styles', get_template_directory_uri() . '/assets/css/style.min.css', array(), null );
}
add_action( 'wp_enqueue_scripts', 'certy_styles' );

/**
 * Enqueue scripts
 */
function certy_scripts() {

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply', '', array(), null );
    }
    $key = kirki::get_option('certy_kirki_config','google_map_api_key');
    $map_key = '';
    if(!empty($key)){
        $map_key = $key;
    }

    // Modernizer
    wp_enqueue_script( 'certy-Modernizer-js', get_template_directory_uri() . '/assets/js/vendor/modernizr-3.3.1.min.js', '', null, false );
    // jQuery
    wp_enqueue_script( 'jquery' );
    // Google Map
    wp_enqueue_script( 'certy-google-map', 'https://maps.googleapis.com/maps/api/js?key='.$map_key, array( 'jquery' ), null, true );
    // Plugins
    wp_enqueue_script( 'certy-plugins-js', get_template_directory_uri() . '/assets/js/plugins.min.js', array( 'jquery' ), null, true );
    // Main
    wp_enqueue_script( 'certy-main-js', get_template_directory_uri() . '/assets/js/theme.min.js', array( 'jquery' ), null, true );

    // Passing Data From WP to JavaScript
    // Inside js get like this: certy_vars_from_WP.themeColor
    $js_options= js_options();
    $certy_pass_js_vars = array(
        'themeColor' => $js_options['primary_color'],
        'mapStyles' => $js_options['google_map_style'],
        'enable_sticky' => $js_options['enable_sticky']
    );

    wp_localize_script( 'certy-main-js', 'certy_vars_from_WP', $certy_pass_js_vars );
}
add_action( 'wp_enqueue_scripts', 'certy_scripts', 10 );