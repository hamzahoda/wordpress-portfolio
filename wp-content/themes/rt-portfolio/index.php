<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package RT_Portfolio
 */

get_header();
?>

<div class="section service-section">
	<div class="container">
		<div class="row">

		<?php
		if ( have_posts() ) : ?>			
			<div class="custom-col-4">
				<header>
					<h2 class="page-title screen-reader-text"><?php single_post_title(); ?></h2>
				</header>
			</div>
			<div class="custom-col-8">
				<div class="service-detail-wrapper">
					<?php /* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/*
						 * Include the Post-Type-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_type() );

					endwhile;

					do_action( 'rt_portfolio_action_navigation'); ?>
				</div>
			</div>
		<?php else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</div>
	</div>
</div>
<?php
get_footer();
