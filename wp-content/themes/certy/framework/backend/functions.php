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
 * Theme Activation
 */
require_once( CERTY_BACKEND_PATH . 'activation/functions.php' );

/**
 * ACF functionality
 */
require_once( CERTY_BACKEND_PATH . 'acf/acf.php' );

/**
 * theme functions
 */
require_once( CERTY_BACKEND_PATH . 'theme-functions/functions.php' );

/**
 * Customizer functionality
 */
require_once( CERTY_BACKEND_PATH . 'customizer/functions.php' );

/**
 * Sidebar/widgets functionality
 */
require_once( CERTY_BACKEND_PATH . 'widgets/functions.php' );


