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
 * Include Kirki Customizer
 */
require_once( CERTY_BACKEND_PATH . 'customizer/kirki/kirki.php' );

/**
 * Include Kirki Options
 */
require_once( CERTY_BACKEND_PATH . 'customizer/kirki.php' );