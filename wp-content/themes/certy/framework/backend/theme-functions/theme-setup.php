<?php
/**
 * Certy theme setup
 *
 * @package Certy_Theme
 */
/**
* Sets up theme defaults and registers support for various WordPress features.
*
* Note that this function is hooked into the after_setup_theme hook, which
* runs before the init hook. The init hook is too late for some features, such
* as indicating support for post thumbnails.
*/
// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

function certy_setup() {
/*
* Make theme available for translation.
* Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/certy
* If you're building a theme based on Twenty Seventeen, use a find and replace
* to change 'certy' to the name of your theme in all the template files.
*/
load_theme_textdomain( 'certy' );

// Add default posts and comments RSS feed links to head.
add_theme_support( 'automatic-feed-links' );

//remove revisions from pages
add_action('admin_init', 'certy_disable_revisions');
function certy_disable_revisions(){
    remove_post_type_support('page', 'revisions');
}

// Enable shortcodes in text widgets and excerpts
add_filter('widget_text','do_shortcode');
add_filter( 'the_excerpt', 'shortcode_unautop');
add_filter( 'the_excerpt', 'do_shortcode');

//modify excerpts
function certy_excerpt_more( $more ) {
    return '...';
}
add_filter('excerpt_more', 'certy_excerpt_more');


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

    add_image_size( 'certy-thumbnail-widget', 80, 60, true );
    add_image_size( 'certy-thumbnail-vertical', 42, 42, true );
    add_image_size( 'certy-thumbnail-vertical-2x', 84, 84, true );

    add_image_size( 'certy-thumbnail-avatar', 195, 195, true );
    add_image_size( 'certy-thumbnail-avatar-2x', 390, 390, true );

    add_image_size( 'certy-thumbnail-references', 54, 54, true );
    add_image_size( 'certy-thumbnail-references-2x', 108, 108, true );

    add_image_size( 'certy-thumbnail', 120, '', true );
    add_image_size( 'certy-portfolio', 380, '', true );
    add_image_size( 'certy-portfolio-popup', 650, 454, true );
    add_image_size( 'certy-portfolio-popup-related', 123, 92, true );

    add_image_size( 'certy-blog', 768, 289, true );
    add_image_size( 'certy-post-nav', 225, 126, true );


    // Set the default content width.
    $GLOBALS['content_width'] = 768;

    // This theme uses wp_nav_menu() in two locations.
    register_nav_menus( array(
    'primary'    => __( 'Primary Menu', 'certy' ),
    'vertical' => __( 'Vertical Navigation', 'certy' ),
    ) );

    /*
    * Switch default core markup for search form, comment form, and comments
    * to output valid HTML5.
    */
    add_theme_support( 'html5', array(
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
    ) );

    /*
    * Enable support for Post Formats.
    *
    * See: https://codex.wordpress.org/Post_Formats
    */
    add_theme_support( 'post-formats', array(
    'video',
    'gallery',
    'audio',
    ) );

    // Add theme support for Custom Logo.
    add_theme_support( 'custom-logo', array(
    'width'       => 250,
    'height'      => 250,
    'flex-width'  => true,
    ) );

    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );

    }
    add_action( 'after_setup_theme', 'certy_setup' );

