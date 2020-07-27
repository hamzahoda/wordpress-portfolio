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
 * theme functions
 */
require_once( CERTY_BACKEND_PATH . 'theme-functions/theme-functions.php' );

/**
 * theme setup
 */
require_once( CERTY_BACKEND_PATH . 'theme-functions/theme-setup.php' );

/**
 * veritcal menu walker
 */
require_once( CERTY_BACKEND_PATH . 'theme-functions/vertical-menu.php' );