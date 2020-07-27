<?php
/**
 * My Portfolio Theme Customizer
 *
 * @package RT_Portfolio
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function rt_portfolio_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->register_section_type( 'rt_portfolio_Customize_Section_Upsell' );

	// Register sections.
	$wp_customize->add_section(
		new rt_portfolio_Customize_Section_Upsell(
			$wp_customize,
			'theme_upsell',
			array(
				'title'    => esc_html__( 'RT Portfolio Pro', 'rt-portfolio' ),
				'pro_text' => esc_html__( 'Buy Pro', 'rt-portfolio' ),
				'pro_url'  => 'https://rigorousthemes.com/downloads/rt-portfolio-pro/',
				'priority' => 1,
			)
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'rt_portfolio_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'rt_portfolio_customize_partial_blogdescription',
		) );
	}
	// Load Callback option.
	require get_template_directory() . '/inc/customizer/callback.php';			

	// Load Customize Sanitize.
	require trailingslashit( get_template_directory() ) . '/inc/customizer/sanitize.php';

	// Load Theme Option.
	require get_template_directory() . '/inc/customizer/theme-section.php';

	// Load Home Option.
	require get_template_directory() . '/inc/customizer/home-section.php';	
	
}
add_action( 'customize_register', 'rt_portfolio_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function rt_portfolio_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function rt_portfolio_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function rt_portfolio_customize_preview_js() {
	wp_enqueue_script( 'rt-portfolio-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'rt_portfolio_customize_preview_js' );

/**
 *  Customizer Control 
 */
function rt_portfolio_customize_backend_scripts() {

	wp_enqueue_style( 'rt-portfolio-admin-customizer-style', get_template_directory_uri() . '/inc/customizer/css/customizer-style.css' );
	
	wp_enqueue_script( 'rt-portfolio-admin-customizer', get_template_directory_uri() . '/inc/customizer/js/customizer-scipt.js', array( ), '20151215', true );
}
add_action( 'customize_controls_enqueue_scripts', 'rt_portfolio_customize_backend_scripts', 10 );
