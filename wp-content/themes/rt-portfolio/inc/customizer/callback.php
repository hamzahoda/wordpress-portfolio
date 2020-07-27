<?php
/**
 * Customizer Callback Function.
 *
 * @package RT_Portfolio
 */
/***************Active Banner Image ******************/
if ( ! function_exists( 'rt_portfolio_active_banner' ) ) :
	function rt_portfolio_active_banner( $control ) { 
		if( 'default' == $control->manager->get_setting('theme_options[banner_img_layout]')->value() ){	

			return true;	

		} else {	

			return false;	

		}

	}
endif;

/***************Slider Banner Image ******************/
if ( ! function_exists( 'rt_portfolio_active_slider' ) ) :
	function rt_portfolio_active_slider( $control ) { 
		if( 'slider' == $control->manager->get_setting('theme_options[banner_img_layout]')->value() ){	

			return true;	

		} else {	

			return false;	

		}

	}
endif;
