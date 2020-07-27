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

/*
 * include customizer functions
 */
require_once( CERTY_FRONTEND_PATH . 'theme-functions/customizer-functions.php' );

/**
 * theme frontend functions
 */
require_once( CERTY_FRONTEND_PATH . 'theme-functions/theme-functions.php' );

/**
 * theme enque scripts and styles
 */
require_once( CERTY_FRONTEND_PATH . 'theme-functions/theme-enque.php' );

/**
 * theme add classes to body and post
 */
require_once( CERTY_FRONTEND_PATH . 'theme-functions/theme-classes.php' );

/**
 * theme add inline styles to wp_head
 */
require_once( CERTY_FRONTEND_PATH . 'theme-functions/theme-styles.php' );