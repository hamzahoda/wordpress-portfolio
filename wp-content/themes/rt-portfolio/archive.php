<?php
/**
 * The template for displaying archive pages
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

			<?php if ( have_posts() ) : ?>

				<div class="custom-col-4">
					<header class="entry-header heading">
						<?php
						the_archive_title( '<h2 class="entry-title">', '</h2>' );
						the_archive_description( '<div class="archive-description">', '</div>' );
						?>
					</header>
				</div>	
				<div class="custom-col-8">
					<div class="service-detail-wrapper">
						<?php
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/*
							 * Include the Post-Type-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_type() );

						endwhile;

						do_action( 'rt_portfolio_action_navigation');
						?>
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
