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
 * @return array of google fonts
 */
function certy_get_google_fonts()
{
    $key = Kirki::get_option('certy_kirki_config', 'google_font_api_key');
    if (!empty($key)) {
        $fontsSeraliazed = json_decode(wp_remote_fopen('https://www.googleapis.com/webfonts/v1/webfonts?key=' . $key));
        $redux_font = array();
        if (!isset($fontsSeraliazed->error)) {
            $fontArray = $fontsSeraliazed->items;
            if (is_array($fontArray)) {
                foreach ($fontArray as $key =>$font) {
                    $redux_font[$font->family.'_'.$font->category] = $font->family;
                }
                return $redux_font;
            }
        }else{
            return $fontsSeraliazed->error;
        }
    }else{
        
        $message = __( 'Please fill in the "Google Font Api Key"', 'certy' );
        return (array) apply_filters( 'certy/messages/missed-google-font-api-key', $message );
    }
}

/**
 * @param $upload_mimes
 * @return mixed
 */

function certy_add_svg_to_upload_mimes( $upload_mimes ) {
    $upload_mimes['svg'] = 'image/svg+xml';
    $upload_mimes['svgz'] = 'image/svg+xml';
    return $upload_mimes;
}
add_filter( 'upload_mimes', 'certy_add_svg_to_upload_mimes', 10, 1 );