<?php
/*
Plugin Name:    Certy Extensions
Description:    Add custom functionality to Certy theme ( Post Types and Shortcodes )
Author:         Px-Lab
Author URI:     http://px-lab.com
Version:        1.0.1
Text Domain:    certy-extensions
Domain Path:    /languages/
License:        GNU General Public License v2.0
License URI:    http://www.gnu.org/licenses/gpl-2.0.html
*/

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

/*define text-domain*/
if ( ! defined( 'CERTY_EXTENSIONS_TEXT_DOMAIN' ) ) {
    define( 'CERTY_EXTENSIONS_TEXT_DOMAIN', 'certy-extensions' );
}

/*Load the plugin translations*/
load_plugin_textdomain( 'certy-extensions', false, dirname( plugin_basename( __FILE__ ) ). '/languages' );
load_plugin_textdomain( 'certy-extensions' );

/*Certy Post Types*/
require_once plugin_dir_path(__FILE__) . 'post-types/functions.php';

/*Certy Shortcodes*/
require_once plugin_dir_path(__FILE__) . 'shortcodes/shortcodes.php';