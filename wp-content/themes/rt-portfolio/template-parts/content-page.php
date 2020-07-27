<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package RT_Portfolio
 */

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php rt_portfolio_post_thumbnail(); ?>
		<h3 class="entry-title">
			<a href="#"><?php the_title();?></a>
		</h3>		
		<div class="entry-content">
			<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'rt-portfolio' ),
				'after'  => '</div>',
			) );
			?>
		</div><!-- .entry-content -->	
	</article><!-- #post-<?php the_ID(); ?> -->

