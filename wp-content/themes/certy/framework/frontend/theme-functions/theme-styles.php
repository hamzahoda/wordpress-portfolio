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
 * Push styles to wp_head
 */
function hook_css() {
    $typography_options = certy_typography_options();
    $certy_color_options = certy_color_options();
    $bg_options = bg_options();

    $output = '';
    $output .= "<style type='text/css'>";

    if (!empty($typography_options['main_font_family'])) {
        $output .= $typography_options['main_font_family'];
    }

    if (!empty($typography_options['heading_font_family'])) {
        $output .= $typography_options['heading_font_family'];
    }

    if (!empty($typography_options['logo_font_family'])) {
        $output .= $typography_options['logo_font_family'];
    }

    if (!empty($typography_options['button_font_family'])) {
        $output .= $typography_options['button_font_family'];
    }

    //bg options
    if(!empty($bg_options['bg_image'])){
        $output .= "body {
            background-image: url({$bg_options['bg_image']});
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;";
            if($bg_options['bg_image_style'] == 'fixed') {
                $output .= "background-attachment: fixed;";
            }
        $output .= "}";
    }

    if(!empty($bg_options['enable_bg_overlay']) && !empty($bg_options['bg_image'])){
        $output .= "body:before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: {$bg_options['overlay_color']};
                z-index: -1;
            }";
    }

    //main color
    if (!empty($certy_color_options['primary_color'])){
        $output .= ".text-primary,
                    .crt-icon-list .crt-icon,
                    .post-title a:hover,
                    .crt-nav .menu-item-object-post.current-menu-item a,
                    .crt-nav .menu-item-object-page.current-menu-item a,
                    .crt-nav .menu-item-object-category.current-menu-item a,

                     .fc-state-active,
                     .fc-state-active .fc-button-inner{
                        color: {$certy_color_options['primary_color']};
                    }
                    
                    mark,
                    input[type='submit'],
                    .bg-primary,
                    .btn-primary,
                    .bg-primary.text-dropcup-sq,
                    .raiting-circle .fill,
                    .progress-bullets .bullet.fill,
                    .tabs .tabs-menu li.active a,
                    .tabs .tabs-menu li a:hover,
                    .togglebox-header:before,
                    .accordion-header:before,
                    .education:before,
                    .education-date,
                    .widget_calendar tbody a,
                    #crtMainNav .sub-menu li > a:hover,
                    #crtMainNav .sub-menu .current-menu-item > a,
                    #crtMainNavSm .sub-menu:before,

                    .apcal_btn-primary,
                    .apcal_btn-primary:hover,
                    #buttonbox .apcal_btn-success,
                    #buttonbox .apcal_btn-success:hover,
                    .apcal_alert-info
                     {
                        background-color: {$certy_color_options['primary_color']};
                    }

                    .btn-bordered,
                    .brd-primary,
                    #crtNavSm .current a,
                    #crtNavSm .menu-item-object-post.current-menu-item a,
                    #crtNavSm .menu-item-object-page.current-menu-item a,
                    #crtNavSm .menu-item-object-category.current-menu-item a,
                    .progress-bullets .bullet,
                    .education-date:after,
                    .education-date:before,

                     .apcal_modal-body .apcal_alert-info
                     {
                        border-color: {$certy_color_options['primary_color']};
                    }
                    
                    ::-moz-selection {
                        background-color: {$certy_color_options['primary_color']};
                    }
                    
                    ::selection {
                        background-color: {$certy_color_options['primary_color']};
                    }";
    }

    //primary text color
    if (!empty($certy_color_options['primary_text_color'])) {
        $output .= ".crt-card,
                    .btn-primary,
                    input[type='submit'],
                    .education-date,

                    .apcal_btn-primary,
                    .apcal_btn-primary:hover,
                    #buttonbox .apcal_btn-success,
                    #buttonbox .apcal_btn-success:hover,
                    .apcal_alert-info,
                    .tabs .tabs-menu li.active a,
                    .tabs .tabs-menu li a:hover,
                    .accordion-header,
                    .togglebox-header {
                        color: {$certy_color_options['primary_text_color']};
                    }

                    ::-moz-selection {
                        color: {$certy_color_options['primary_text_color']};
                    }

                    ::selection {
                        color: {$certy_color_options['primary_text_color']};
                    }

                    .bg-primary .btn-bordered {
                        border-color: {$certy_color_options['primary_text_color']};
                        color: {$certy_color_options['primary_text_color']};
                    }";
    }

    //main text color
    if (!empty($certy_color_options['main_text_color'])){
        $output .= "body,
                    blockquote.quote-top:before,
                    blockquote.quote-side:before,
                    .form-item,
                    .crt-logo,
                    .page-numbers:hover,
                    .page-numbers.current,
                    .tabs .tabs-menu a,
                    .crt-nav a,
                    .crt-tooltip,
                    #crtMainNav .sub-menu a,
                    #crtMainNav > ul > li > a:hover,
                    #crtMainNav > ul > li.current-menu-item > a,
                    #crtMainNav > ul > li.current-menu-parent > a,
                    #crtMainNavSm li > a:hover,
                    #crtMainNavSm li.current-menu-item a,
                    #crtMainNavSm li.current-menu-parent a,
                    .accordion li.active .accordion-header,
                    .accordion-header:hover,
                    .togglebox li.active .togglebox-header,
                    .togglebox-header:hover,
                    .pf-filter button,
                    .search-title span,
                    .widget_archive a,
                    .widget_categories a {
                        color: {$certy_color_options['main_text_color']};
                    }
                    
                    ::-webkit-input-placeholder {
                        color: {$certy_color_options['main_text_color']};
                    }
                    
                    ::-moz-placeholder {
                        color: {$certy_color_options['main_text_color']};
                    }
                    
                    :-ms-input-placeholder {
                        color: {$certy_color_options['main_text_color']};
                    }
                    
                    :-moz-placeholder {
                        color: {$certy_color_options['main_text_color']};
                    }
                    
                    .text-dropcup-sq,
                    .styled-ul li:before,
                    .education-box:before {
                        background-color: {$certy_color_options['main_text_color']};
                    }";
    }

    //muted text color
    if (!empty($certy_color_options['muted_text_color'])) {
        $output .= ".text-muted,
                    .post-content,
                    .page-numbers,
                    .education-company,
                    .ref-author span,
                    table > thead > tr > th,
                    .styled-ul > li > ul ul,
                    #crtMainNav > ul > li > a,
                    #crtMainNavSm a,
                    .cr-carousel .slick-next:before,
                    .cr-carousel .slick-prev:before,
                    .widget-title,
                    .widget_archive li,
                    .widget_categories li,
                    .widget_recent_entries .post-date,
                    .post-category-comment a,

                    #timesloatbox,
                    .apcal_modal-info .icon-remove
                     {
                        color: {$certy_color_options['muted_text_color']};
                    }
                    
                    .styled-ul > li > ul ul li:before {
                        background-color: {$certy_color_options['muted_text_color']};
                    }";
    }

    //border color
    if (!empty($certy_color_options['border_color'])) {
        $output .= "hr,
                    th,
                    td,
                    blockquote,
                    .brd-btm,
                    .post-tags a,
                    .reference-box,
                    .crt-head-inner,
                    .crt-paper,
                    .crt-paper-layers:after,
                    .crt-paper-layers:before,
                    #comments .comment-list,
                    #comments .comment-body,
                    .crt-nav-type1 .crt-nav-cont,
                    .tabs .tabs-menu,
                    .tabs-vertical:before,
                    .page-category .post-footer,
                    .search-for,
                    .widget_meta > ul,
                    .widget_pages > ul,
                    .widget_archive > ul,
                    .widget_nav_menu .menu,
                    .widget_categories > ul,
                    .widget_recent_entries > ul,
                    .widget_recent_comments > ul,
                    .widget_meta li,
                    .widget_pages li,
                    .widget_archive li,
                    .widget_nav_menu li,
                    .widget_categories li,
                    .widget_recent_entries li,
                    .widget_recent_comments li,
                    .widget_calendar caption,
                    .widget_tag_cloud a,
                    .post-category-comment a,

                     .apcal_modal,
                     .apcal_btn#next1,
                     .apcal_btn#back
                     {
                        border-color: {$certy_color_options['border_color']};
                    }
                    
                    .crt-nav-btm:after {
                        background-color: {$certy_color_options['border_color']};
                    }
                    
                    .post-line {
                        color: {$certy_color_options['border_color']};
                    }";
    }

    //left shape color
    if (!empty($certy_color_options['shape_color_left'])) {
        $output .= "#crtBgShape1 polygon {
                        fill: {$certy_color_options['shape_color_left']};
                    }";
    }

    //right shape color
    if (!empty($certy_color_options['shape_color_right'])) {
        $output .= "#crtBgShape2 polygon {
                        fill: {$certy_color_options['shape_color_right']};
                    }";
    }

    //body bg color
    if (!empty($certy_color_options['body_color'])) {
        $output .= "body,
                    select,
                    textarea,
                    input[type='url'],
                    input[type='tel'],
                    input[type='time'],
                    input[type='text'],
                    input[type='email'],
                    input[type='number'],
                    input[type='search'],
                    input[type='password'],
                    input[type='week'],
                    input[type='date'],
                    input[type='datetime'],
                    input[type='datetime-local'],
                    input[type='month'],
                    .form-item,
                    .widget_search input[type=\"text\"],

                    .fc-state-highlight
                     {
                        background-color: {$certy_color_options['body_color']};
                    }";
    }

    //paper bg color
    if (!empty($certy_color_options['paper_color'])) {
        $output .= ".text-dropcup-sq {
                        color: {$certy_color_options['paper_color']};
                    }
                    
                    .crt-head-inner,
                    .crt-card-footer,
                    blockquote.quote-top:before,
                    blockquote.quote-side:before,
                    .tooltip:after,
                    .education-box:last-child:after,
                    .crt-nav-type1 .crt-nav-cont,
                    #crtMainNav .sub-menu,
                    .crt-tooltip:after,
                    #crtSidebar,
                    .pf-popup-content,
                    .cr-carousel .slick-next,
                    .cr-carousel .slick-prev,
                    .crt-side-box-1,
                    .crt-side-box-2,
                    .crt-side-box-2 .widget,
                    #crtContainer,
                    .crt-paper,
                    .crt-paper-layers:after,
                    .crt-paper-layers:before,
                    #crtSidebarBtn,
                    #crtSidebarClose,
                    .crt-side-box-1 #sticky-widget-inner{
                        background-color: {$certy_color_options['paper_color']};
                    }
                    
                    .tooltip:before {
                        border-top-color: {$certy_color_options['paper_color']};
                    }
                    
                    .crt-nav-type1 .crt-nav-btm,
                    .crt-tooltip.arrow-right:before {
                        border-left-color: {$certy_color_options['paper_color']};
                    }
                    
                    .crt-tooltip.arrow-left:before {
                        border-right-color: {$certy_color_options['paper_color']};
                    }";
    }

    //default buttons bg color
    if (!empty($certy_color_options['default_buttons_color'])) {
        $output .= ".btn-default {
                        background-color: {$certy_color_options['default_buttons_color']};
                    }";
    }

    //default buttons text color
    if (!empty($certy_color_options['default_buttons_text_color'])) {
        $output .= ".btn-default {
                        color: {$certy_color_options['default_buttons_text_color']};
                    }";
    }

    //secondary buttons bg color
    if (!empty($certy_color_options['secondary_buttons_color'])) {
        $output .= ".btn-secondary {
                        background-color: {$certy_color_options['secondary_buttons_color']};
                    }";
    }

    //secondary buttons text color
    if (!empty($certy_color_options['secondary_buttons_text_color'])) {
        $output .= ".btn-secondary {
                        color: {$certy_color_options['secondary_buttons_text_color']};
                    }";
    }

    $output.="</style>";

    echo $output;

}
add_action('wp_head','hook_css');