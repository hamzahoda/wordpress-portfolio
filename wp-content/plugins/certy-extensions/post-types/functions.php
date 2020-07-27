<?php
/**
 * certy extension
 *
 * @package certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

/*Portfolio Post Type*/
require_once plugin_dir_path(__FILE__) . 'portfolio.php';

/*Timeline Post Type*/
require_once plugin_dir_path(__FILE__) . 'timeline.php';

/*References Post Type*/
require_once plugin_dir_path(__FILE__) . 'references.php';

/*Clients Post Type*/
require_once plugin_dir_path(__FILE__) . 'clients.php';