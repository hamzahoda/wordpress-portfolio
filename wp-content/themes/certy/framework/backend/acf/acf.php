<?php
/**
 * @package certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

add_filter('acf/settings/save_json', 'certy_acf_json_save_point');
/**
 * @param $path
 * @return string
 */
function certy_acf_json_save_point( $path ) {

    // update path
    $path = CERTY_BACKEND_PATH . '/acf';

    // return
    return $path;

}

add_filter('acf/settings/load_json', 'certy_acf_json_load_point');
/**
 * @param $paths
 * @return array
 */
function certy_acf_json_load_point( $paths ) {

    // remove original path (optional)
    unset($paths[0]);


    // append path
    $paths[] = CERTY_BACKEND_PATH . '/acf';


    // return
    return $paths;

}

if ( !class_exists( 'acf' ) && !is_admin()){
    function get_field(){
        return '';
    }
}


/**
 * @param $value
 * @return mixed
 *  Disable ACF, App Calendar Update Notification
 */
function certy_filter_plugin_updates($value) {
    if ( isset( $value ) && is_object( $value ) ) {
        unset($value->response[ 'appointment-calendar/appointment-calendar.php' ]);
    }
    return $value;
}
add_filter('site_transient_update_plugins', 'certy_filter_plugin_updates');