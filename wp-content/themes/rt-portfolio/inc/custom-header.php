<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package RT_Portfolio
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses rt_portfolio_header_style()
 */
function rt_portfolio_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'rt_portfolio_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 1000,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'rt_portfolio_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'rt_portfolio_custom_header_setup' );


function rt_portfolio_header_style() {
	wp_enqueue_style( 'rt-portfolio-style', get_stylesheet_uri() );
	$header_text_color 	= get_header_textcolor();	
	if ( is_singular() ){
		$header_image = rt_portfolio_header_image();
	} else{
		$header_image = get_header_image();
	}
	
	$position = "absolute";
	$custom_css = '';
	$clip ="rect(1px, 1px, 1px, 1px)";
	if ( ! display_header_text() ) {
		$custom_css .= '.site-title, .site-description{
			position: '.$position.';
			clip: '.$clip.'; 
		}';
	} else{

		$custom_css .= '.site-title a, .site-description {
			color: #' . esc_attr($header_text_color) . ';			
		}';
	}

	$custom_css .= '.service-section::before{
		background: url("'.$header_image.'") no-repeat scroll center center;

	}';

	wp_add_inline_style( 'rt-portfolio-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'rt_portfolio_header_style' );