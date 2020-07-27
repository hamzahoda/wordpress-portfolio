<?php
/**
 * Default theme options.
 *
 * @package RT_Portfolio
 */

if ( ! function_exists( 'rt_portfolio_get_default_theme_options' ) ) :

	/**
	 * Get default theme options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
function rt_portfolio_get_default_theme_options() {

	$defaults = array();

	$defaults['site_identity']						= 'title-text';
	$defaults['enable_single_menu']					= true;
	$defaults['enable_search']						= true;
	$defaults['enable_social_menu']					= true;

	/*************************** Banner Section *******************************/
	$defaults['enable_home']						= true;	
	$defaults['home_menu_title']					= esc_html__( 'Home','rt-portfolio');
	$defaults['home_section_title']					= esc_html__( 'About Me','rt-portfolio');
	$defaults['banner_page']						= 0;
	$defaults['home_sub_title']						= esc_html__( 'UI/UX','rt-portfolio');

	/**************************About Page Section *****************************/
	$defaults['enable_aboutus']						= true;	
	$defaults['aboutus_menu_title']					= esc_html__( 'About us','rt-portfolio');
	$defaults['intro_section_title']				= esc_html__( 'Who Am I?','rt-portfolio');	
	$defaults['intro_page_first']					= 0;
	$defaults['intro_title_first']					= esc_html__( 'About Me', 'rt-portfolio' );
	$defaults['intro_page_second']					= 0;
	$defaults['intro_title_second']					= esc_html__( 'History', 'rt-portfolio' );

	/*****************************Service Section **********************************/
	$defaults['enable_service']						= true;	
	$defaults['service_menu_title']					= esc_html__( 'Service','rt-portfolio');
	$defaults['service_section_title']				= esc_html__( 'What I Do?','rt-portfolio');
	$defaults['service_category']					= 0;
	$defaults['service_number']						= 4;

	/*****************************Portfolio Section **********************************/
	$defaults['enable_portfolio']					= true;
	$defaults['portfolio_bg_image']					= '';
	$defaults['portfolio_menu_title']				= esc_html__( 'Portfolio','rt-portfolio');
	$defaults['portfolio_section_title']			= esc_html__( 'My Work','rt-portfolio');
	$defaults['portfolio_category']					= 0;
	$defaults['portfolio_number']					= 4;

	/*****************************Testimonial Section **********************************/
	$defaults['enable_testimonial']					= true;
	$defaults['enable_partner']						= true;	
	$defaults['testimonial_menu_title']				= esc_html__( 'Testimonial','rt-portfolio');
	$defaults['testimonial_section_title']			= esc_html__( 'My Clients','rt-portfolio');
	$defaults['testimonial_category']				= 0;
	$defaults['testimonial_number']					= 4;
	$defaults['partner_title']						= esc_html__( 'Partner','rt-portfolio');

	/***************************** Team Section **********************************/
	$defaults['enable_team']						= true;	
	$defaults['team_menu_title']					= esc_html__( 'Team','rt-portfolio');
	$defaults['team_section_title']					= esc_html__( 'My Team','rt-portfolio');
	$defaults['team_category']						= 0;
	$defaults['team_number']						= 4;

	/***************************** Blog Section **********************************/
	$defaults['enable_blog']						= true;	
	$defaults['blog_menu_title']					= esc_html__( 'Blog','rt-portfolio');
	$defaults['blog_section_title']					= esc_html__( 'My Tips & Tricks','rt-portfolio');
	$defaults['blog_category']						= 0;
	$defaults['blog_number']						= 4;	

	/***************************** Contact Section **********************************/
	$defaults['enable_contact']						= true;	
	$defaults['contact_menu_title']					= esc_html__( 'Contact','rt-portfolio');
	$defaults['contact_section_title']				= esc_html__( 'Get in Touch','rt-portfolio');	
	$defaults['contact_page']						= 0;
	$defaults['contact_callback_html']				= '';

	/******************************** General Section **************************************/
	$defaults['enable_author']						= true;
	$defaults['enable_posted_date']					= true;
	$defaults['pagination_option']					= 'default';
	$defaults['blog_content_option']				= 'excpert';

	/******************************** Footer Section **************************************/
	$defaults['enable_footer_social_menu']			= true;
	$defaults['social_menu_title']					= esc_html__( 'Follow Me','rt-portfolio');	

	// Pass through filter.
	$defaults = apply_filters( 'rt_portfolio_filter_default_theme_options', $defaults );
	return $defaults;
}

endif;

/**
*  Get theme options
*/
if ( ! function_exists( 'rt_portfolio_get_option' ) ) :

	/**
	 * Get theme option
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Option key.
	 * @return mixed Option value.
	 */
	function rt_portfolio_get_option( $key ) {

		$default_options = rt_portfolio_get_default_theme_options();

		if ( empty( $key ) ) {
			return;
		}

		$theme_options = (array)get_theme_mod( 'theme_options' );
		$theme_options = wp_parse_args( $theme_options, $default_options );

		$value = null;

		if ( isset( $theme_options[ $key ] ) ) {
			$value = $theme_options[ $key ];
		}

		return $value;

	}

endif;