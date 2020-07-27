<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package RT_Portfolio
 */

?><?php
	/**
	 * Hook - rt_portfolio_action_doctype.
	 *
	 * @hooked rt_portfolio_doctype -  10
	 */
	do_action( 'rt_portfolio_action_doctype' );
?>

<head>
	<?php
	/**
	 * Hook - rt_portfolio_action_head.
	 *
	 * @hooked rt_portfolio_head -  10
	 */
	do_action( 'rt_portfolio_action_head' );
	?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php
		/**
		 * Hook - rt_portfolio_action_before.
		 *
		 * @hooked rt_portfolio_page_start - 10
		 * 
		 */
		do_action( 'rt_portfolio_action_before' );
	?>
	<?php 
		/**
		 * Hook - rt_portfolio_side_action_header
		 *
		 * @hooked rt_portfolio_side_header -10
		 *
		 */
		do_action( 'rt_portfolio_side_action_header' );
	?>	

	<?php 
		/**
		 * Hook - rt_portfolio_action_before_header
		 *
		 * @hooked rt_portfolio_header_start -10
		 *
		 */
		do_action( 'rt_portfolio_action_before_header' );
	?>
	<?php 
		/**
		 * Hook - rt_portfolio_action_header
		 *
		 * @hooked rt_portfolio_site_branding -10
		 *
		 */
		do_action( 'rt_portfolio_action_header' );
	?>
	<?php 
		/**
		 * Hook - rt_portfolio_action_after_header
		 *
		 * @hooked rt_portfolio_header_end -10
		 *
		 */
		do_action( 'rt_portfolio_action_after_header' );
	?>

	<?php 
		/**
		 * Hook - rt_portfolio_action_before_content
		 *
		 * @hooked rt_portfolio_content_start -10
		 *
		 */
		do_action( 'rt_portfolio_action_before_content' );
	?>
