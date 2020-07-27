<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package RT_Portfolio
 */

get_header();
?>
<div class="section service-section">
	<div class="container">
		<div class="row">
				<?php
				while ( have_posts() ) :
					the_post();
				?>
				<div class="custom-col-4">
					<header class="entry-header heading">
						<h2 class="entry-title"><?php the_title();?></h2>
					</header>
				</div>	
				<div class="custom-col-8">
					<div class="service-detail-wrapper">				

						<?php get_template_part( 'template-parts/content', 'single' ); 

						the_post_navigation();

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;	
						?>
					</div>
				</div>
				<?php 

				endwhile; // End of the loop.
				?>
		</div>
	</div>
</div>

<?php
get_footer();
