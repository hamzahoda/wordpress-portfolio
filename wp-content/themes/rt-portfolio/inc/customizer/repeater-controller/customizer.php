<?php
/**
* Repeater customizer
*
* @package RT_Portfolio
*/

/**
* Load scripts for repeater 
*/
function rt_portfolio_enqueue_repeater_scripts() {
    wp_enqueue_script( 'rt-portfolio-repeater-script', get_template_directory_uri() . '/inc/customizer/repeater-controller/repeater-script.js',array( 'jquery','jquery-ui-sortable'));
    wp_enqueue_style('rt-portfolio-repeater-style',get_template_directory_uri() . '/inc/customizer/repeater-controller/repeater-style.css');
} 
add_action( 'admin_enqueue_scripts', 'rt_portfolio_enqueue_repeater_scripts');


/**
* Repeater customizer
*/
function rt_portfolio_repeaters_customize_register( $wp_customize ) {
    
    require get_template_directory().'/inc/customizer/repeater-controller/repeater-class.php';    

    /**
    * Repeater Sanitize
    */
    function rt_portfolio_sanitize_repeater($input){      
        $input_decoded = json_decode( $input, true );
        
        if(!empty($input_decoded)) {
            foreach ($input_decoded as $boxes => $box ){
                foreach ($box as $key => $value){

                    $input_decoded[$boxes][$key] = sanitize_text_field( $value );
                }
            }
            return json_encode($input_decoded);
        }    
        return $input;
    }

    /**
    * Repeater Sanitize for html filter
    */
    function rt_portfolio_html_sanitize_repeater($input){      
        $input_decoded = json_decode( $input, true );
        if(!empty($input_decoded)) {
            foreach ($input_decoded as $boxes => $box ){
                foreach ($box as $key => $value){

                    $input_decoded[$boxes][$key] = wp_kses_post( $value );
                }
            }
            return json_encode($input_decoded);
        }    
        return $input;
    }
    
}
add_action( 'customize_register', 'rt_portfolio_repeaters_customize_register' );