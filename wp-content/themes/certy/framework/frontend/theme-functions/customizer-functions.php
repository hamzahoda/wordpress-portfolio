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
 * get logo options from customizer
 * @return array
 */
function certy_header_options(){
    $header_options = array();
    $header_options['custom_logo'] = Kirki::get_option('certy_kirki_config', 'custom_logo');
    $header_options['logo_text'] = Kirki::get_option('certy_kirki_config', 'logo_text');
    $header_options['logo_position'] = Kirki::get_option('certy_kirki_config', 'logo_position');
    $header_options['custom_logo_retina'] = Kirki::get_option('certy_kirki_config', 'custom_logo_retina');
    $header_options['hide_logo_area'] = Kirki::get_option('certy_kirki_config', 'hide_logo_area');
    $header_options['menu_position'] = Kirki::get_option('certy_kirki_config', 'menu_position');
    $header_options['logo_position'] = Kirki::get_option('certy_kirki_config', 'logo_position');
    $header_options['primary_color'] = Kirki::get_option('certy_kirki_config', 'primary_color');
    return $header_options;
}

/**
 * get logo options from customizer
 * @return array
 */
function certy_vertical_nav_options(){
    $vertical_nav_options = array();
    $vertical_nav_options['personal_image'] = Kirki::get_option('certy_kirki_config', 'personal_image');
    $vertical_nav_options['link_for_personal_image'] = Kirki::get_option('certy_kirki_config', 'link_for_personal_image');
    $vertical_nav_options['tooltip_for_personal_image'] = Kirki::get_option('certy_kirki_config', 'tooltip_for_personal_image');
    $vertical_nav_options['enable_sticky'] = Kirki::get_option('certy_kirki_config', 'enable_sticky');
    $vertical_nav_options['show_vertical_navigation_home'] = Kirki::get_option('certy_kirki_config', 'show_vertical_navigation_home');
    return $vertical_nav_options;
}

/**
 * get 404 page options from customizer
 * @return array
 */
function certy_404_options(){
    $notfound_options = array();
    $notfound_options['404_title'] = Kirki::get_option('certy_kirki_config', '404_title');
    $notfound_options['404_description'] = Kirki::get_option('certy_kirki_config', '404_description');
    $notfound_options['404_button_text'] = Kirki::get_option('certy_kirki_config', '404_button_text');
    return $notfound_options;
}

/**
 * get typography options from customizer
 * @return array
 */
function certy_typography_options($enque = false){
    $typography_options = array();
    $main_font_family = explode("_",Kirki::get_option('certy_kirki_config', 'main_font_family'));
    $heading_font_family = explode("_",Kirki::get_option('certy_kirki_config', 'heading_font_family'));
    $logo_font_family = explode("_",Kirki::get_option('certy_kirki_config', 'logo_font_family'));
    $button_font_family = explode("_",Kirki::get_option('certy_kirki_config', 'button_font_family'));

    $typography_options['main_font_family'] = '';
    $typography_options['heading_font_family'] = '';
    $typography_options['logo_font_family'] = '';
    $typography_options['button_font_family'] = '';

    if(!$enque) {
        if (!empty($main_font_family[1]) && $main_font_family[0] != 'option-1') {
            $typography_options['main_font_family'] = "
        body {
            font-family: '$main_font_family[0]', $main_font_family[1]; }
        ";
        }
        if (!empty($heading_font_family[1]) && $heading_font_family[0] != 'option-1') {
            $typography_options['heading_font_family'] = "
        h1, h2, h3, h4, h5, h6 {
            font-family: '$heading_font_family[0]', $heading_font_family[1]; }
        ";
        }
        if (!empty($logo_font_family[1]) && $logo_font_family[0] != 'option-1') {
            $typography_options['logo_font_family'] = "
        .crt-logo {
            font-family: '$logo_font_family[0]', $logo_font_family[1]; }
        ";
        }
        if (!empty($button_font_family[1]) && $button_font_family[0] != 'option-1') {
            $typography_options['button_font_family'] = "
        .btn, input[type=submit] {
            font-family: '$button_font_family[0]', $button_font_family[1]; }
        ";
        }
    }else{
        if(!empty($main_font_family) && $main_font_family[0] != 'option-1'){
            $typography_options['main_font_family'] = str_replace(" ", "+", $main_font_family[0]);
        }else{
            $typography_options['main_font_family'] = 'Quicksand';
        }
        if(!empty($heading_font_family) && $heading_font_family[0] != 'option-1'){
            $typography_options['heading_font_family'] = str_replace(" ", "+", $heading_font_family[0]);
        }else{
            $typography_options['heading_font_family'] = 'Quicksand';
        }
        if(!empty($logo_font_family) && $logo_font_family[0] != 'option-1'){
            $typography_options['logo_font_family'] = str_replace(" ", "+", $logo_font_family[0]);
        }else{
            $typography_options['logo_font_family'] = 'Pacifico';
        }
        if(!empty($button_font_family) && $button_font_family[0] != 'option-1'){
            $typography_options['button_font_family'] = str_replace(" ", "+", $button_font_family[0]);
        }else{
            $typography_options['button_font_family'] = 'Quicksand';
        }
    }

    return $typography_options;
}

/**
 * get footer options from customizer
 * @return array
 */
function footer_options(){
    $footer_options = array();
    $footer_options['footer_content'] = kirki::get_option('certy_kirki_config','footer_content');
    $footer_options['disable_left_shape'] = Kirki::get_option('certy_kirki_config', 'disable_left_shape');
    $footer_options['disable_right_shape'] = Kirki::get_option('certy_kirki_config', 'disable_right_shape');
    $footer_options['hide_go_top'] = Kirki::get_option('certy_kirki_config', 'hide_go_top');
    return $footer_options;
}

/**
 * get color options from customizer
 * @return array
 */
function certy_color_options(){
    $color_options = array();
    $color_options['primary_color'] = Kirki::get_option('certy_kirki_config', 'primary_color');
    $color_options['primary_text_color'] = Kirki::get_option('certy_kirki_config', 'primary_text_color');
    $color_options['main_text_color'] = Kirki::get_option('certy_kirki_config', 'main_text_color');
    $color_options['muted_text_color'] = Kirki::get_option('certy_kirki_config', 'muted_text_color');
    $color_options['border_color'] = Kirki::get_option('certy_kirki_config', 'border_color');
    $color_options['shape_color_left'] = Kirki::get_option('certy_kirki_config', 'shape_color_left');
    $color_options['shape_color_right'] = Kirki::get_option('certy_kirki_config', 'shape_color_right');
    $color_options['body_color'] = Kirki::get_option('certy_kirki_config', 'body_color');
    $color_options['paper_color'] = Kirki::get_option('certy_kirki_config', 'paper_color');
    $color_options['default_buttons_color'] = Kirki::get_option('certy_kirki_config', 'default_buttons_color');
    $color_options['default_buttons_text_color'] = Kirki::get_option('certy_kirki_config', 'default_buttons_text_color');
    $color_options['secondary_buttons_color'] = Kirki::get_option('certy_kirki_config', 'secondary_buttons_color');
    $color_options['secondary_buttons_text_color'] = Kirki::get_option('certy_kirki_config', 'secondary_buttons_text_color');
    return $color_options;
}

/**
 * get options for passing to js
 * @return array
 */
function js_options(){
    $js_options = array();
    $js_options['primary_color'] = kirki::get_option('certy_kirki_config','primary_color');
    $js_options['google_map_style'] = Kirki::get_option('certy_kirki_config', 'google_map_style');
    $js_options['google_map_style'] = Kirki::get_option('certy_kirki_config', 'google_map_style');
    $js_options['enable_sticky'] = Kirki::get_option('certy_kirki_config', 'enable_sticky');
    return $js_options;
}

/**
 * get background options
 * @return array
 */
function bg_options(){
    $bg_options = array();
    $bg_options['bg_image'] = kirki::get_option('certy_kirki_config','bg_image');
    $bg_options['enable_bg_overlay'] = kirki::get_option('certy_kirki_config','enable_bg_overlay');
    $bg_options['bg_image_style'] = kirki::get_option('certy_kirki_config','bg_image_style');
    $bg_options['overlay_color'] = kirki::get_option('certy_kirki_config','overlay_color');
    return $bg_options;
}