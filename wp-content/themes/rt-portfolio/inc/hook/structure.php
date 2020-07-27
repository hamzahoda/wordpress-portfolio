<?php
/**
 * Theme functions related to structure.
 *
 * This file contains structural hook functions.
 *
 * @package RT_Portfolio
 */

if ( ! function_exists( 'rt_portfolio_doctype' ) ) :
	/**
	 * Doctype Declaration.
	 *
	 * @since 1.0.0
	 */
	function rt_portfolio_doctype() {
	?><!DOCTYPE html> <html <?php language_attributes(); ?>><?php
	}
endif;

add_action( 'rt_portfolio_action_doctype', 'rt_portfolio_doctype', 10 );

if ( !function_exists( 'rt_portfolio_head' ) ) :
	/**
	 * Header Codes.
	 *
	 * @since 1.0.0
	 */
	function rt_portfolio_head() {
	?>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> 
	<?php
	}
endif;

add_action( 'rt_portfolio_action_head', 'rt_portfolio_head', 10 );

if ( ! function_exists( 'rt_portfolio_page_start' ) ) :
	/**
	 * Page Start.
	 *
	 * @since 1.0.0
	 */
	function rt_portfolio_page_start() {
	?>
    <div id="page" class="hfeed site">
    	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'rt-portfolio' ); ?></a>
    <?php
	}
endif;
add_action( 'rt_portfolio_action_before', 'rt_portfolio_page_start' );

if ( ! function_exists( 'rt_portfolio_page_end' ) ) :
	/**
	 * Page End.
	 *
	 * @since 1.0.0
	 */
	function rt_portfolio_page_end() {
	?></div><!-- #page --><?php
	}
endif;
add_action( 'rt_portfolio_action_after', 'rt_portfolio_page_end' );

if ( ! function_exists( 'rt_portfolio_content_start' ) ) :
	/**
	 * Content Start.
	 *
	 * @since 1.0.0
	 */
	function rt_portfolio_content_start() {
	?><div id="myfullpage" class="site-content"><?php
	}
endif;
add_action( 'rt_portfolio_action_before_content', 'rt_portfolio_content_start' );


if ( ! function_exists( 'rt_portfolio_content_end' ) ) :
	/**
	 * Content End.
	 *
	 * @since 1.0.0
	 */
	function rt_portfolio_content_end() {
	?></div><!-- #content --><?php
	}
endif;
add_action( 'rt_portfolio_action_after_content', 'rt_portfolio_content_end' );


if ( ! function_exists( 'rt_portfolio_header_start' ) ) :
	/**
	 * Header Start
	 *
	 * @since 1.0.0
	 */
	function rt_portfolio_header_start() {
	?>
	<header id="masthead" class="site-header"> <!-- header starting from here --><?php	
	}
endif;

add_action( 'rt_portfolio_action_before_header', 'rt_portfolio_header_start', 10 );


if ( ! function_exists( 'rt_portfolio_header_end' ) ) :
	/**
	 * Header End
	 *
	 * @since 1.0.0
	 */
	function rt_portfolio_header_end() {
	?></header><!-- header ends here --><?php	
	}
endif;
add_action( 'rt_portfolio_action_after_header', 'rt_portfolio_header_end', 10 );

if ( ! function_exists( 'rt_portfolio_footer_start' ) ) :
	/**
	 * Footer Start.
	 *
	 * @since 1.0.0
	 */
	function rt_portfolio_footer_start() {
	?><footer id="colophon" class="site-footer"> <!-- footer starting from here --> 
	<?php
	}
endif;
add_action( 'rt_portfolio_action_before_footer', 'rt_portfolio_footer_start' );


if ( ! function_exists( 'rt_portfolio_footer_end' ) ) :
	/**
	 * Footer End.
	 *
	 * @since 1.0.0
	 */
	function rt_portfolio_footer_end() {
	?></footer><!-- #colophon --><?php
	}
endif;
add_action( 'rt_portfolio_action_after_footer', 'rt_portfolio_footer_end' );