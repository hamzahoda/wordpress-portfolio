<?php
/**
 * My Portfolio functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package RT_Portfolio
 */

if ( ! function_exists( 'rt_portfolio_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function rt_portfolio_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on My Portfolio, use a find and replace
		 * to change 'rt-portfolio' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'rt-portfolio', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'rt-portfolio-slider', 620, 403, array( 'center', 'center') );
		add_image_size( 'rt-portfolio-portfolio', 204, 367, array( 'center', 'center') );
		add_image_size( 'rt-portfolio-testimonial', 227, 289, array( 'center', 'center') );
		add_image_size( 'rt-portfolio-blog', 620, 155, array( 'center', 'center') );
		add_image_size( 'rt-portfolio-home', 450, 500, array( 'center', 'center') );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'rt-portfolio' ),
			'social-menu' => esc_html__( 'Social Menu', 'rt-portfolio' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'rt_portfolio_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
		add_theme_support( 'custom-header', array(
			'default-image' => get_template_directory_uri() . '/assets/img/default-img.png',
			'height'      => 491,
			'width'       => 400,
		) );		
	}
endif;
add_action( 'after_setup_theme', 'rt_portfolio_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function rt_portfolio_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'rt_portfolio_content_width', 640 );
}
add_action( 'after_setup_theme', 'rt_portfolio_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function rt_portfolio_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'rt-portfolio' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'rt-portfolio' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'rt_portfolio_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function rt_portfolio_scripts() {

	wp_enqueue_style( 'rt-portfolio-fonts', rt_portfolio_fonts_url(), array(), null );	

	//fontawesome css
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css' );

	//meanmenu css
	wp_enqueue_style( 'jquery-meanmenu', get_template_directory_uri() . '/assets/css/meanmenu.css' );

	//owl-carousel css
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/assets/css/owl.carousel.css' );

	//owl theme default css
	wp_enqueue_style( 'owl.theme.default', get_template_directory_uri() . '/assets/css/owl.theme.css' );	

	wp_enqueue_style( 'rt-portfolio-style', get_stylesheet_uri() );

	//Responsive css
	wp_enqueue_style( 'rt-portfolio-responsive', get_template_directory_uri() . '/assets/css/responsive.css' );

	wp_enqueue_script( 'rt-portfolio-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'rt-portfolio-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );	

	//carousel
	wp_enqueue_script( 'jquery-carousel-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.js', array('jquery'), 'v2.2.1', true );

	//Counterup
	wp_enqueue_script( 'jquery-counterup', get_template_directory_uri() . '/assets/js/jquery.counterup.min.js', array('jquery'), 'v2.2.1', true );

	//nice scroll
	wp_enqueue_script( 'jquery-nicescroll', get_template_directory_uri() . '/assets/js/jquery.nicescroll.js', array('jquery'), 'v2.2.1', true );

	//waypoints
	wp_enqueue_script( 'jquery-waypoints', get_template_directory_uri() . '/assets/js/jquery.waypoints.min.js', array('jquery'), '4.0.1', true );		

	//Full Page
	wp_enqueue_script( 'jquery-fullpage', get_template_directory_uri() . '/assets/js/jquery.fullpage.min.js', array('jquery'), '2.9.7', true );					

	//jquery-meanmenu
	wp_enqueue_script( 'jquery-meanmenu', get_template_directory_uri() . '/assets/js/jquery.meanmenu.js', array('jquery'), 'v2.0.8', true );

	//custom
	wp_enqueue_script( 'rt-portfolio-custom', get_template_directory_uri() . '/assets/js/custom.js', array(), '20180717', true );	


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$enabled_sections 	= rt_portfolio_get_sections();
	$sections = array();

	foreach ($enabled_sections as $section ) {
		$sections[] = $section['id'];
	}
	
	wp_localize_script('rt-portfolio-custom', 'rt_portfolio_var', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'anchors' => $sections,	
	));

}
add_action( 'wp_enqueue_scripts', 'rt_portfolio_scripts' );

/**
 * Load init.
 */
require_once trailingslashit( get_template_directory() ) . '/inc/init.php';


