<?php
/**
 * Certy frontend functions
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

/**
 * Extend the default WordPress body classes. *
 * Adds body classes
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function certy_body_classes( $classes ) {
    $vertical_navigation_bg = Kirki::get_option('certy_kirki_config', 'show_vertical_navigation_bg');
    $vertical_nav_show_home = Kirki::get_option('certy_kirki_config', 'show_vertical_navigation_home');
    $paper_layers_count = Kirki::get_option('certy_kirki_config', 'paper_layers_count');

    $classes[] = 'crt';
    $classes[] = 'crt-layers-'.$paper_layers_count;

    // vertical navigation
    if ( has_nav_menu( 'vertical' ) && (empty($vertical_nav_show_home) || (!empty($vertical_nav_show_home) && is_front_page())) ){
        $classes[] = 'crt-nav-on';
        if(!empty($vertical_navigation_bg)){
            $classes[] = 'crt-nav-type1';
        }else{
            $classes[] = 'crt-nav-type2';
        }
    } else {
        $classes[] = 'crt-nav-off';
    }

    // main navigation
    if ( has_nav_menu( 'primary' ) ){
        $classes[] = 'crt-main-nav-on';
    } else {
        $classes[] = 'crt-main-nav-off';
    }

    // left sidebar
    $left_sidebar = check_left_sidebar();
    if($left_sidebar){
        $classes[] = 'crt-side-box-on';
    } else {
        $classes[] = 'crt-side-box-off';
    }

    // right sidebar
    $sidebar = check_sidebar();
    if($sidebar){
        $classes[] = 'crt-sidebar-on';
    } else {
        $classes[] = 'crt-sidebar-off';
    }

    return $classes;
}
add_filter( 'body_class', 'certy_body_classes' );