<?php
/**
 * Template Name: Home Page
 *
 * @package RT_Portfolio
 */

get_header(); ?>

<?php $enable_single_menu  = rt_portfolio_get_option( 'enable_single_menu' ); 

if ( true == $enable_single_menu ) { 

	/***************** Home Section **********************************/
	get_template_part( 'template-parts/section/section', 'homesection' );

	/***************** About Us Section **********************************/
	get_template_part( 'template-parts/section/section', 'aboutussection' );

	/*****************Service Section **********************************/
	get_template_part( 'template-parts/section/section', 'servicesection' );	

	/*****************Portfolio Section **********************************/
	get_template_part( 'template-parts/section/section', 'portfoliosection' );

	/*****************Testimonial Section **********************************/
	get_template_part( 'template-parts/section/section', 'testimonialsection' );	

	/*****************Team Section **********************************/
	get_template_part( 'template-parts/section/section', 'teamsection' );	

	/*****************Blog Section **********************************/
	get_template_part( 'template-parts/section/section', 'blogsection' );

	/*****************Contact Section **********************************/
	get_template_part( 'template-parts/section/section', 'contactsection' );	

} else {	?>			
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

							<?php get_template_part( 'template-parts/content', 'page' ); 


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
<?php } ?>	 

<?php 
get_footer();