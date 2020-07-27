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
 * class-tgm-plugin-activation
 */
require_once( CERTY_BACKEND_PATH . 'activation/class-tgm-plugin-activation.php' );

/**
 * Plugins Activation
 */
require_once( CERTY_BACKEND_PATH . 'activation/plugins-activation.php' );

/**
 * One Click Demo Options
 */
if( !function_exists('is_plugin_active') ) {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}
if(is_plugin_active('one-click-demo-import/one-click-demo-import.php')) {
    require_once(CERTY_BACKEND_PATH . 'activation/one_click_demo.php');
}