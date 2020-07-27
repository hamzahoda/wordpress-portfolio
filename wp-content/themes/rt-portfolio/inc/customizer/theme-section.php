<?php
/**
 * My Portfolio Theme Customizer
 *
 * @package RT_Portfolio
 */
$default = rt_portfolio_get_default_theme_options();

/****************  Add Pannel   ***********************/
$wp_customize->add_panel( 'theme_option_panel',
	array(
	'title'      => esc_html__( 'Theme Options', 'rt-portfolio' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	)
);
/************************  Site Identity  ******************/
$wp_customize->add_setting('theme_options[site_identity]', 
	array(
	'default' 			=> $default['site_identity'],
	'sanitize_callback' => 'rt_portfolio_sanitize_select'
	)
);
$wp_customize->add_control('theme_options[site_identity]', 
	array(		
	'label' 	=> esc_html__('Choose Option', 'rt-portfolio'),
	'section' 	=> 'title_tagline',
	'settings'  => 'theme_options[site_identity]',
	'type' 		=> 'radio',
	'choices' 	=>  array(
			'logo-only' 	=> esc_html__('Logo Only', 'rt-portfolio'),
			'logo-text' 	=> esc_html__('Logo + Tagline', 'rt-portfolio'),
			'title-only' 	=> esc_html__('Title Only', 'rt-portfolio'),
			'title-text' 	=> esc_html__('Title + Tagline', 'rt-portfolio')
		)
	)
);

/****************  Header Setting Section starts ************/
$wp_customize->add_section('section_header', 
	array(    
	'title'       => esc_html__('Header Setting', 'rt-portfolio'),
	'panel'       => 'theme_option_panel'    
	)
);

/********************* Enable Single Page Menu ****************************/
$wp_customize->add_setting( 'theme_options[enable_single_menu]',
	array(
		'default'           => $default['enable_single_menu'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'rt_portfolio_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[enable_single_menu]',
	array(
		'label'    => esc_html__( 'Enable One Page', 'rt-portfolio' ),
		'section'  => 'section_header',
		'type'     => 'checkbox',		
	)
);

/********************* Enable Search ****************************/
$wp_customize->add_setting( 'theme_options[enable_search]',
	array(
		'default'           => $default['enable_search'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'rt_portfolio_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[enable_search]',
	array(
		'label'    => esc_html__( 'Enable Search', 'rt-portfolio' ),
		'section'  => 'section_header',
		'type'     => 'checkbox',		
	)
);

/********************* Enable Social Menu ****************************/
$wp_customize->add_setting( 'theme_options[enable_social_menu]',
	array(
		'default'           => $default['enable_social_menu'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'rt_portfolio_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[enable_social_menu]',
	array(
		'label'    => esc_html__( 'Enable Social Menu', 'rt-portfolio' ),
		'section'  => 'section_header',
		'type'     => 'checkbox',		
	)
);

/**************** General Section ************/
$wp_customize->add_section('section_general', 
	array(    
	'title'       => esc_html__('General Setting', 'rt-portfolio'),
	'panel'       => 'theme_option_panel'    
	)
);

/********************* Enable Author ****************************/
$wp_customize->add_setting( 'theme_options[enable_author]',
	array(
		'default'           => $default['enable_author'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'rt_portfolio_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[enable_author]',
	array(
		'label'    => esc_html__( 'Enable Author', 'rt-portfolio' ),
		'section'  => 'section_general',
		'type'     => 'checkbox',		
	)
);

/********************* Enable Posted Date ****************************/
$wp_customize->add_setting( 'theme_options[enable_posted_date]',
	array(
		'default'           => $default['enable_posted_date'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'rt_portfolio_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[enable_posted_date]',
	array(
		'label'    => esc_html__( 'Enable Posted Date', 'rt-portfolio' ),
		'section'  => 'section_general',
		'type'     => 'checkbox',		
	)
);

// Pagination Option
$wp_customize->add_setting('theme_options[pagination_option]', 
	array(
	'default' 			=> $default['pagination_option'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'rt_portfolio_sanitize_select'
	)
);

$wp_customize->add_control('theme_options[pagination_option]', 
	array(		
	'label' 	=> esc_html__('Pagination Options', 'rt-portfolio'),
	'section' 	=> 'section_general',
	'settings'  => 'theme_options[pagination_option]',
	'type' 		=> 'radio',
	'choices' 	=> array(		
		'default' 		=> esc_html__('Default', 'rt-portfolio'),							
		'numeric' 		=> esc_html__('Numeric', 'rt-portfolio'),		
		),	
	)
);

// Content Option
$wp_customize->add_setting('theme_options[blog_content_option]', 
	array(
	'default' 			=> $default['blog_content_option'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'rt_portfolio_sanitize_select'
	)
);

$wp_customize->add_control('theme_options[blog_content_option]', 
	array(		
	'label' 	=> esc_html__('Archive Page Content Options', 'rt-portfolio'),
	'section' 	=> 'section_general',
	'settings'  => 'theme_options[blog_content_option]',
	'type' 		=> 'radio',
	'choices' 	=> array(		
		'content' 		=> esc_html__('Full Content', 'rt-portfolio'),							
		'excpert' 		=> esc_html__('Excerpt', 'rt-portfolio'),		
		),	
	)
);

/**************** Footer Section ************/
$wp_customize->add_section('section_footer', 
	array(    
	'title'       => esc_html__('Footer Setting', 'rt-portfolio'),
	'panel'       => 'theme_option_panel'    
	)
);

/********************* Enable Social Menu ****************************/
$wp_customize->add_setting( 'theme_options[enable_footer_social_menu]',
	array(
		'default'           => $default['enable_footer_social_menu'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'rt_portfolio_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[enable_footer_social_menu]',
	array(
		'label'    => esc_html__( 'Enable Social Menu', 'rt-portfolio' ),
		'section'  => 'section_footer',
		'type'     => 'checkbox',		
	)
);

// Social Menu Title
$wp_customize->add_setting('theme_options[social_menu_title]', 
	array(
	'default'           => $default['social_menu_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[social_menu_title]', 
	array(
	'label'       => esc_html__('Title', 'rt-portfolio'),
	'section'     => 'section_footer',   
	'settings'    => 'theme_options[social_menu_title]',		
	'type'        => 'text',
	)
);