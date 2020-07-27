<?php
/**
 * My Portfolio Home Customizer
 *
 * @package RT_Portfolio
 */
$default = rt_portfolio_get_default_theme_options();

/****************  Add Home Pannel   ***********************/
$wp_customize->add_panel( 'home_option_panel',
	array(
	'title'      => esc_html__( 'Front Page Options', 'rt-portfolio' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	)
);

/********************** Banner Section. *************************************/
$wp_customize->add_section('section_banner', 
	array(    
	'title'       => esc_html__('Banner Setting', 'rt-portfolio'),
	'priority'    => 100,
	'panel'       => 'home_option_panel'    
	)
);

// Enable Banner
$wp_customize->add_setting( 'theme_options[enable_home]',
	array(
		'default'           => $default['enable_home'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'rt_portfolio_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[enable_home]',
	array(
		'label'    => esc_html__( 'Enable Banner', 'rt-portfolio' ),
		'section'  => 'section_banner',
		'type'     => 'checkbox',		
	)
);

// Menu Title
$wp_customize->add_setting('theme_options[home_menu_title]', 
	array(
	'default'           => $default['home_menu_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[home_menu_title]', 
	array(
	'label'       => esc_html__('Menu Title', 'rt-portfolio'),
	'section'     => 'section_banner',   
	'settings'    => 'theme_options[home_menu_title]',		
	'type'        => 'text',
	)
);

// Banner Section Title
$wp_customize->add_setting('theme_options[home_section_title]', 
	array(
	'default'           => $default['home_section_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[home_section_title]', 
	array(
	'label'       => esc_html__('Section Title', 'rt-portfolio'),
	'section'     => 'section_banner',   
	'settings'    => 'theme_options[home_section_title]',		
	'type'        => 'text',
	)
);

// Banner Page
$wp_customize->add_setting('theme_options[banner_page]', 
	array(
	'default'           => $default['banner_page'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'rt_portfolio_sanitize_dropdown_pages'
	)
);

$wp_customize->add_control('theme_options[banner_page]', 
	array(
	'label'       => esc_html__('Select Page', 'rt-portfolio'),
    'description' => esc_html__( 'Select page from dropdown or leave blank if you want to hide this section.', 'rt-portfolio' ), 
	'section'     => 'section_banner',   
	'settings'    => 'theme_options[banner_page]',		
	'type'        => 'dropdown-pages', 
	)
);

// Banner Section Sub Title
$wp_customize->add_setting('theme_options[home_sub_title]', 
	array(
	'default'           => $default['home_sub_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[home_sub_title]', 
	array(
	'label'       => esc_html__('Sub Title', 'rt-portfolio'),
	'section'     => 'section_banner',   
	'settings'    => 'theme_options[home_sub_title]',		
	'type'        => 'text',
	)
);


// Progress
$wp_customize->add_setting( 'theme_options[progress_secton]', array(
    'sanitize_callback' => 'rt_portfolio_sanitize_repeater',
    'default' => json_encode(
        array(
            array(
                'progress_number'=> '',
                'progress_title' => '',
                'progress_icon'  => '',
            )
        )
    )
));

$wp_customize->add_control(  new RT_Portfolio_Repeater_Controler( $wp_customize, 'theme_options[progress_secton]', 
    array(
        'label'                        => esc_html__('Progress Bar Options','rt-portfolio'),
        'section'                      => 'section_banner',
        'rt_portfolio_box_label'         => esc_html__('Progress Bar','rt-portfolio'),
        'rt_portfolio_box_add_control'   => esc_html__('Add Progress Bar','rt-portfolio'),  
    ),
    array(
        'progress_number' => array(
        'type'        => 'number',
        'label'       => esc_html__( 'Number', 'rt-portfolio' ),
        'default'     => '',	            
        ),

        'progress_icon' => array(
        'type'        => 'text',
        'label'       => esc_html__( 'Symbol', 'rt-portfolio' ),        
        'default'     => '',		       
    	),        
            
        'progress_title' => array(
        'type'        => 'text',
        'label'       => esc_html__( 'Title', 'rt-portfolio' ),
        'default'     => '',		       
    	),	
    )
));

/********************** About Section. *************************************/
$wp_customize->add_section('section_about_us', 
	array(    
	'title'       => esc_html__('About Setting', 'rt-portfolio'),
	'priority'    => 110,
	'panel'       => 'home_option_panel'    
	)
);
// Enable About Section
$wp_customize->add_setting( 'theme_options[enable_aboutus]',
	array(
		'default'           => $default['enable_aboutus'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'rt_portfolio_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[enable_aboutus]',
	array(
		'label'    => esc_html__( 'Enable About Section', 'rt-portfolio' ),
		'section'  => 'section_about_us',
		'type'     => 'checkbox',		
	)
);

// Menu Title
$wp_customize->add_setting('theme_options[aboutus_menu_title]', 
	array(
	'default'           => $default['aboutus_menu_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[aboutus_menu_title]', 
	array(
	'label'       => esc_html__('Menu Title', 'rt-portfolio'),
	'section'     => 'section_about_us',   
	'settings'    => 'theme_options[aboutus_menu_title]',		
	'type'        => 'text',
	)
);

// Intro Section Title
$wp_customize->add_setting('theme_options[intro_section_title]', 
	array(
	'default'           => $default['intro_section_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[intro_section_title]', 
	array(
	'label'       => esc_html__('Section Title', 'rt-portfolio'),
	'section'     => 'section_about_us',   
	'settings'    => 'theme_options[intro_section_title]',		
	'type'        => 'text',
	)
);

/**************** About Page First Title **********************************************/
$wp_customize->add_setting('theme_options[intro_title_first]', 
	array(
	'default'           => $default['intro_title_first'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[intro_title_first]', 
	array(
	'label'       => esc_html__('Intro Page Title', 'rt-portfolio'),
	'section'     => 'section_about_us',   
	'settings'    => 'theme_options[intro_title_first]',		
	'type'        => 'text',	
	)
);

/****************************  About page First ********************************/
$wp_customize->add_setting('theme_options[intro_page_first]', 
	array(
	'default'           => $default['intro_page_first'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'rt_portfolio_sanitize_dropdown_pages'
	)
);

$wp_customize->add_control('theme_options[intro_page_first]', 
	array(
	'label'       => esc_html__('Select Page', 'rt-portfolio'),
    'description' => esc_html__( 'Select page from dropdown or leave blank if you want to hide this section.', 'rt-portfolio' ), 
	'section'     => 'section_about_us',   
	'settings'    => 'theme_options[intro_page_first]',		
	'type'        => 'dropdown-pages'
	)
);

/******************* About Page Second Title *********************************/
$wp_customize->add_setting('theme_options[intro_title_second]', 
	array(
	'default'           => $default['intro_title_second'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[intro_title_second]', 
	array(
	'label'       => esc_html__('Intro Page Title', 'rt-portfolio'),
	'section'     => 'section_about_us',   
	'settings'    => 'theme_options[intro_title_second]',		
	'type'        => 'text',	
	)
);

/********************* About page Second *******************************************/
$wp_customize->add_setting('theme_options[intro_page_second]', 
	array(
	'default'           => $default['intro_page_second'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'rt_portfolio_sanitize_dropdown_pages'
	)
);

$wp_customize->add_control('theme_options[intro_page_second]', 
	array(
	'label'       => esc_html__('Select Page', 'rt-portfolio'),
    'description' => esc_html__( 'Select page from dropdown or leave blank if you want to hide this section.', 'rt-portfolio' ), 
	'section'     => 'section_about_us',   
	'settings'    => 'theme_options[intro_page_second]',		
	'type'        => 'dropdown-pages'
	)
);

// Counter
$wp_customize->add_setting( 'theme_options[counter_secton]', array(
    'sanitize_callback' => 'rt_portfolio_sanitize_repeater',
    'default' => json_encode(
        array(
            array(
                'counter_number'=> '',
                'counter_title' => '',
            )
        )
    )
));

$wp_customize->add_control(  new RT_Portfolio_Repeater_Controler( $wp_customize, 'theme_options[counter_secton]', 
    array(
        'label'                        => esc_html__('Counter Options','rt-portfolio'),
        'section'                      => 'section_about_us',
        'rt_portfolio_box_label'         => esc_html__('Counter','rt-portfolio'),
        'rt_portfolio_box_add_control'   => esc_html__('Add Counter','rt-portfolio'),
    ),
    array(
        'counter_number' => array(
        'type'        => 'number',
        'label'       => esc_html__( 'Number', 'rt-portfolio' ),
        'default'     => '',	            
        ),
            
        'counter_title' => array(
        'type'        => 'text',
        'label'       => esc_html__( 'Title', 'rt-portfolio' ),
        'default'     => '',		       
    	),	
    )
));

/********************** Service Section. *************************************/
$wp_customize->add_section('section_service', 
	array(    
	'title'       => esc_html__('Service Setting', 'rt-portfolio'),
	'priority'    => 120,	
	'panel'       => 'home_option_panel'    
	)
);

// Enable Service Section
$wp_customize->add_setting( 'theme_options[enable_service]',
	array(
		'default'           => $default['enable_service'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'rt_portfolio_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[enable_service]',
	array(
		'label'    => esc_html__( 'Enable Service Section', 'rt-portfolio' ),
		'section'  => 'section_service',
		'type'     => 'checkbox',		
	)
);


// Menu Title
$wp_customize->add_setting('theme_options[service_menu_title]', 
	array(
	'default'           => $default['service_menu_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[service_menu_title]', 
	array(
	'label'       => esc_html__('Service Menu Title', 'rt-portfolio'),
	'section'     => 'section_service',   
	'settings'    => 'theme_options[service_menu_title]',		
	'type'        => 'text',
	)
);

// Service Section Title
$wp_customize->add_setting('theme_options[service_section_title]', 
	array(
	'default'           => $default['service_section_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[service_section_title]', 
	array(
	'label'       => esc_html__('Section Title', 'rt-portfolio'),
	'section'     => 'section_service',   
	'settings'    => 'theme_options[service_section_title]',		
	'type'        => 'text',
	)
);

/********************* Service Category. *****************************************/
$wp_customize->add_setting( 'theme_options[service_category]',
	array(
	'default'           => $default['service_category'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	new RT_Portfolio_Dropdown_Taxonomies_Control( $wp_customize, 'theme_options[service_category]',
		array(
		'label'    => esc_html__( 'Select Category', 'rt-portfolio' ),
		'section'  => 'section_service',
		'settings' => 'theme_options[service_category]',
		)
	)
);

/************************** Service Section Number **************************************/
$wp_customize->add_setting( 'theme_options[service_number]',
	array(
		'default'           => $default['service_number'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'rt_portfolio_sanitize_number_range',
		)
);
$wp_customize->add_control( 'theme_options[service_number]',
	array(
		'label'       => esc_html__( 'Select Number', 'rt-portfolio' ),
		'section'     => 'section_service',
		'type'        => 'number',
		'priority'    => 100,
		'input_attrs' => array( 'min' => 2, 'max' => 6, 'step' => 2, 'style' => 'width: 115px;' ),
	)
);


/********************** Portfolio Section. *************************************/
$wp_customize->add_section('section_portfolio', 
	array(    
	'title'       => esc_html__('Portfolio Setting', 'rt-portfolio'),
	'priority'    => 130,	
	'panel'       => 'home_option_panel'    
	)
);

// Enable Portfolio Section
$wp_customize->add_setting( 'theme_options[enable_portfolio]',
	array(
		'default'           => $default['enable_portfolio'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'rt_portfolio_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[enable_portfolio]',
	array(
		'label'    => esc_html__( 'Enable Portfolio Section', 'rt-portfolio' ),
		'section'  => 'section_portfolio',
		'type'     => 'checkbox',		
	)
);

// Menu Title
$wp_customize->add_setting('theme_options[portfolio_menu_title]', 
	array(
	'default'           => $default['portfolio_menu_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[portfolio_menu_title]', 
	array(
	'label'       => esc_html__('Portfolio Menu Title', 'rt-portfolio'),
	'section'     => 'section_portfolio',   
	'settings'    => 'theme_options[portfolio_menu_title]',		
	'type'        => 'text',
	)
);

// portfolio Section Title
$wp_customize->add_setting('theme_options[portfolio_section_title]', 
	array(
	'default'           => $default['portfolio_section_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[portfolio_section_title]', 
	array(
	'label'       => esc_html__('Section Title', 'rt-portfolio'),
	'section'     => 'section_portfolio',   
	'settings'    => 'theme_options[portfolio_section_title]',		
	'type'        => 'text',
	)
);

/********************* portfolio Category. *****************************************/
$wp_customize->add_setting( 'theme_options[portfolio_category]',
	array(
	'default'           => $default['portfolio_category'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	new RT_Portfolio_Dropdown_Taxonomies_Control( $wp_customize, 'theme_options[portfolio_category]',
		array(
		'label'    => esc_html__( 'Select Category', 'rt-portfolio' ),
		'section'  => 'section_portfolio',
		'settings' => 'theme_options[portfolio_category]',
		)
	)
);

/************************** Portfolio Section Number **************************************/
$wp_customize->add_setting( 'theme_options[portfolio_number]',
	array(
		'default'           => $default['portfolio_number'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'rt_portfolio_sanitize_number_range',
		)
);
$wp_customize->add_control( 'theme_options[portfolio_number]',
	array(
		'label'       => esc_html__( 'Select Number', 'rt-portfolio' ),
		'section'     => 'section_portfolio',
		'type'        => 'number',
		'priority'    => 100,
		'input_attrs' => array( 'min' => 3, 'max' => 6, 'step' => 1, 'style' => 'width: 115px;' ),
	)
);

/********************** Testimonial Section. *************************************/
$wp_customize->add_section('section_testimonial', 
	array(    
	'title'       => esc_html__('Testimonial Setting', 'rt-portfolio'),
	'priority'    => 140,	
	'panel'       => 'home_option_panel'    
	)
);

// Enable Testimonial Section
$wp_customize->add_setting( 'theme_options[enable_testimonial]',
	array(
		'default'           => $default['enable_testimonial'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'rt_portfolio_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[enable_testimonial]',
	array(
		'label'    => esc_html__( 'Enable Testimonial Section', 'rt-portfolio' ),
		'section'  => 'section_testimonial',
		'type'     => 'checkbox',		
	)
);
// Menu Title
$wp_customize->add_setting('theme_options[testimonial_menu_title]', 
	array(
	'default'           => $default['testimonial_menu_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[testimonial_menu_title]', 
	array(
	'label'       => esc_html__('Testimonial Menu Title', 'rt-portfolio'),
	'section'     => 'section_testimonial',   
	'settings'    => 'theme_options[testimonial_menu_title]',		
	'type'        => 'text',
	)
);

// Testimonial Section Title
$wp_customize->add_setting('theme_options[testimonial_section_title]', 
	array(
	'default'           => $default['testimonial_section_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[testimonial_section_title]', 
	array(
	'label'       => esc_html__('Section Title', 'rt-portfolio'),
	'section'     => 'section_testimonial',   
	'settings'    => 'theme_options[testimonial_section_title]',		
	'type'        => 'text',
	)
);

/********************* Testimonial Category. *****************************************/
$wp_customize->add_setting( 'theme_options[testimonial_category]',
	array(
	'default'           => $default['testimonial_category'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	new RT_Portfolio_Dropdown_Taxonomies_Control( $wp_customize, 'theme_options[testimonial_category]',
		array(
		'label'    => esc_html__( 'Select Category', 'rt-portfolio' ),
		'section'  => 'section_testimonial',
		'settings' => 'theme_options[testimonial_category]',
		)
	)
);

/************************** Testimonial Section Number **************************************/
$wp_customize->add_setting( 'theme_options[testimonial_number]',
	array(
		'default'           => $default['testimonial_number'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'rt_portfolio_sanitize_number_range',
		)
);
$wp_customize->add_control( 'theme_options[testimonial_number]',
	array(
		'label'       => esc_html__( 'Select Number', 'rt-portfolio' ),
		'section'     => 'section_testimonial',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 2, 'max' => 6, 'step' => 1, 'style' => 'width: 115px;' ),
	)
);
// Enable Testimonial Section
$wp_customize->add_setting( 'theme_options[enable_partner]',
	array(
		'default'           => $default['enable_partner'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'rt_portfolio_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[enable_partner]',
	array(
		'label'    => esc_html__( 'Enable Partner Section', 'rt-portfolio' ),
		'section'  => 'section_testimonial',
		'type'     => 'checkbox',		
	)
);

// Partner Section Title
$wp_customize->add_setting('theme_options[partner_title]', 
	array(
	'default'           => $default['partner_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[partner_title]', 
	array(
	'label'       => esc_html__('Title', 'rt-portfolio'),
	'section'     => 'section_testimonial',   
	'settings'    => 'theme_options[partner_title]',		
	'type'        => 'text',
	)
);


/**************** Client Logo **********************************************/
$wp_customize->add_setting( 'theme_options[partner_logo]', array(
    'sanitize_callback' => 'rt_portfolio_sanitize_repeater',
    'default' => json_encode(
        array(
            array(
                'client_logo'=> '',               
            )
        )
    )
));

$wp_customize->add_control(  new RT_Portfolio_Repeater_Controler( $wp_customize, 'theme_options[partner_logo]', 
    array(
        'label'                        => esc_html__('Partner Logo Options','rt-portfolio'),
        'section'                      => 'section_testimonial',
        'rt_portfolio_box_label'         => esc_html__('Logo','rt-portfolio'),
        'rt_portfolio_box_add_control'   => esc_html__('Add Logo','rt-portfolio'),
    ),
    array(
        'client_logo' => array(
        'type'        => 'upload',
        'label'       => esc_html__( 'Client Logo', 'rt-portfolio' ),
        'default'     => '',	            
        ),           
    )
));

/********************** Team Section. *************************************/
$wp_customize->add_section('section_team', 
	array(    
	'title'       => esc_html__('Team Setting', 'rt-portfolio'),
	'priority'    => 150,	
	'panel'       => 'home_option_panel'    
	)
);

// Enable Team Section
$wp_customize->add_setting( 'theme_options[enable_team]',
	array(
		'default'           => $default['enable_team'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'rt_portfolio_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[enable_team]',
	array(
		'label'    => esc_html__( 'Enable Team Section', 'rt-portfolio' ),
		'section'  => 'section_team',
		'type'     => 'checkbox',		
	)
);


// Menu Title
$wp_customize->add_setting('theme_options[team_menu_title]', 
	array(
	'default'           => $default['team_menu_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[team_menu_title]', 
	array(
	'label'       => esc_html__('Team Menu Title', 'rt-portfolio'),
	'section'     => 'section_team',   
	'settings'    => 'theme_options[team_menu_title]',		
	'type'        => 'text',
	)
);

// Team Section Title
$wp_customize->add_setting('theme_options[team_section_title]', 
	array(
	'default'           => $default['team_section_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[team_section_title]', 
	array(
	'label'       => esc_html__('Section Title', 'rt-portfolio'),
	'section'     => 'section_team',   
	'settings'    => 'theme_options[team_section_title]',		
	'type'        => 'text',
	)
);

/********************* Team Category. *****************************************/
$wp_customize->add_setting( 'theme_options[team_category]',
	array(
	'default'           => $default['team_category'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	new RT_Portfolio_Dropdown_Taxonomies_Control( $wp_customize, 'theme_options[team_category]',
		array(
		'label'    => esc_html__( 'Select Category', 'rt-portfolio' ),
		'section'  => 'section_team',
		'settings' => 'theme_options[team_category]',
		)
	)
);

/************************** Team Section Number **************************************/
$wp_customize->add_setting( 'theme_options[team_number]',
	array(
		'default'           => $default['team_number'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'rt_portfolio_sanitize_number_range',
		)
);
$wp_customize->add_control( 'theme_options[team_number]',
	array(
		'label'       => esc_html__( 'Select Number', 'rt-portfolio' ),
		'section'     => 'section_team',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 2, 'max' => 6, 'step' => 1, 'style' => 'width: 115px;' ),
	)
);

/********************** Blog Section. *************************************/
$wp_customize->add_section('section_blog', 
	array(    
	'title'       => esc_html__('Blog Setting', 'rt-portfolio'),
	'priority'    => 160,	
	'panel'       => 'home_option_panel'    
	)
);

// Enable Blog Section
$wp_customize->add_setting( 'theme_options[enable_blog]',
	array(
		'default'           => $default['enable_blog'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'rt_portfolio_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[enable_blog]',
	array(
		'label'    => esc_html__( 'Enable Blog Section', 'rt-portfolio' ),
		'section'  => 'section_blog',
		'type'     => 'checkbox',		
	)
);

// Menu Title
$wp_customize->add_setting('theme_options[blog_menu_title]', 
	array(
	'default'           => $default['blog_menu_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[blog_menu_title]', 
	array(
	'label'       => esc_html__('Blog Menu Title', 'rt-portfolio'),
	'section'     => 'section_blog',   
	'settings'    => 'theme_options[blog_menu_title]',		
	'type'        => 'text',
	)
);

// Blog Section Title
$wp_customize->add_setting('theme_options[blog_section_title]', 
	array(
	'default'           => $default['blog_section_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[blog_section_title]', 
	array(
	'label'       => esc_html__('Section Title', 'rt-portfolio'),
	'section'     => 'section_blog',   
	'settings'    => 'theme_options[blog_section_title]',		
	'type'        => 'text',
	)
);

/********************* Blog Category. *****************************************/
$wp_customize->add_setting( 'theme_options[blog_category]',
	array(
	'default'           => $default['blog_category'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'absint',
	)
);
$wp_customize->add_control(
	new RT_Portfolio_Dropdown_Taxonomies_Control( $wp_customize, 'theme_options[blog_category]',
		array(
		'label'    => esc_html__( 'Select Category', 'rt-portfolio' ),
		'section'  => 'section_blog',
		'settings' => 'theme_options[blog_category]',
		)
	)
);

/************************** Blog Section Number **************************************/
$wp_customize->add_setting( 'theme_options[blog_number]',
	array(
		'default'           => $default['blog_number'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'rt_portfolio_sanitize_number_range',
		)
);
$wp_customize->add_control( 'theme_options[blog_number]',
	array(
		'label'       => esc_html__( 'Select Number', 'rt-portfolio' ),
		'section'     => 'section_blog',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 2, 'max' => 6, 'step' => 1, 'style' => 'width: 115px;' ),
	)
);

/********************** Contact Section. *************************************/
$wp_customize->add_section('section_contact', 
	array(    
	'title'       => esc_html__('Contact Setting', 'rt-portfolio'),
	'priority'    => 170,	
	'panel'       => 'home_option_panel'    
	)
);

// Enable Contact Section
$wp_customize->add_setting( 'theme_options[enable_contact]',
	array(
		'default'           => $default['enable_contact'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'rt_portfolio_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[enable_contact]',
	array(
		'label'    => esc_html__( 'Enable Contact Section', 'rt-portfolio' ),
		'section'  => 'section_contact',
		'type'     => 'checkbox',		
	)
);

// Menu Title
$wp_customize->add_setting('theme_options[contact_menu_title]', 
	array(
	'default'           => $default['contact_menu_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[contact_menu_title]', 
	array(
	'label'       => esc_html__('contact Menu Title', 'rt-portfolio'),
	'section'     => 'section_contact',   
	'settings'    => 'theme_options[contact_menu_title]',		
	'type'        => 'text',
	)
);

// Contact Section Title
$wp_customize->add_setting('theme_options[contact_section_title]', 
	array(
	'default'           => $default['contact_section_title'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'sanitize_text_field'
	)
);

$wp_customize->add_control('theme_options[contact_section_title]', 
	array(
	'label'       => esc_html__('Section Title', 'rt-portfolio'),
	'section'     => 'section_contact',   
	'settings'    => 'theme_options[contact_section_title]',		
	'type'        => 'text',
	)
);

// Contact Page
$wp_customize->add_setting('theme_options[contact_page]', 
	array(
	'default'           => $default['contact_page'],
	'type'              => 'theme_mod',
	'capability'        => 'edit_theme_options',	
	'sanitize_callback' => 'rt_portfolio_sanitize_dropdown_pages'
	)
);

$wp_customize->add_control('theme_options[contact_page]', 
	array(
	'label'       => esc_html__('Select Page', 'rt-portfolio'),
    'description' => esc_html__( 'Select page from dropdown or leave blank if you want to hide this section.', 'rt-portfolio' ), 
	'section'     => 'section_contact',   
	'settings'    => 'theme_options[contact_page]',		
	'type'        => 'dropdown-pages'
	)
);


/*********************** Custom Html.  ****************************/
$wp_customize->add_setting( 'theme_options[contact_callback_html]',
	array(
	'default'           => $default['contact_callback_html'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'rt_portfolio_sanitize_textarea_content',	
	)
);
$wp_customize->add_control( 'theme_options[contact_callback_html]',
	array(
	'label'    => esc_html__( 'Call to Action', 'rt-portfolio' ),
	'section'  => 'section_contact',
	'type'     => 'textarea',
	)
);
