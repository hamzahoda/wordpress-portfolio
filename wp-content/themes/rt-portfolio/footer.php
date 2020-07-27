<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package RT_Portfolio
 */

?>

	<?php 
		/**
		 * Hook - rt_portfolio_action_after_content
		 *
		 * @hooked rt_portfolio_content_end -10
		 *
		 */
		do_action( 'rt_portfolio_action_after_content' );
	?>
	<?php 
		/**
		 * Hook - rt_portfolio_action_before_footer
		 *
		 * @hooked rt_portfolio_footer_start -10
		 *
		 */
		do_action( 'rt_portfolio_action_before_footer' );
	?>

	<?php 
		/**
		 * Hook - rt_portfolio_action_footer
		 *
		 * @hooked rt_portfolio_footer_copyright -10
		 *
		 */
		do_action( 'rt_portfolio_action_footer' );
	?>	
	
	<?php 
		/**
		 * Hook - rt_portfolio_action_after_footer
		 *
		 * @hooked rt_portfolio_footer_end -10
		 *
		 */
		do_action( 'rt_portfolio_action_after_footer' );
	?>

	<?php 
		/**
		 * Hook - rt_portfolio_action_footer_content
		 *
		 * @hooked rt_portfolio_footer_social_media -10
		 *
		 */
		do_action( 'rt_portfolio_action_footer_content' );
	?>		

	<?php 
		/**
		 * Hook - rt_portfolio_action_after
		 *
		 * @hooked rt_portfolio_page_end -10
		 *
		 */
		do_action( 'rt_portfolio_action_after' );
	?>

<?php wp_footer(); ?>

</body>
</html>
