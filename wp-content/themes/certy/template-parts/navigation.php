<?php
/**
 * The template for navigation
 *
 * @package Certy_Theme
 */
// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

$location = get_query_var('location');
$theme_location = 'primary';
$walker = '';
if(!empty($location)){
    $theme_location = 'vertical';
    $walker = new Vertical_Certy_Walker();
}
$defaults = array(
    'theme_location'  => $theme_location,
    'container'       => '',
    'menu_class' 	  => '',
    'walker' 	  => $walker,
    'items_wrap'      => '<ul class="clear-list">%3$s</ul>',
);
wp_nav_menu( $defaults );