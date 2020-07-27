<?php
/**
 * Template for Portfolio Section
 *
 * @package RT_Portfolio
 */

$enable_portfolio = rt_portfolio_get_option( 'enable_portfolio' );

if ( false == $enable_portfolio ){
    return;
}
$portfolio_section_title = rt_portfolio_get_option( 'portfolio_section_title' );
$portfolio_category = rt_portfolio_get_option( 'portfolio_category' );
$portfolio_number 	= rt_portfolio_get_option( 'portfolio_number' );

?>
<div class="section portfolio-section" id="portfoliosection">
	<div class="container">
		<div class="row">
			<?php if ( $portfolio_section_title ):?>
				<div class="custom-col-4">
					<header class="entry-header heading">
						<h2 class="entry-title"><?php echo esc_html( $portfolio_section_title );?></h2>
					</header>
				</div>
			<?php endif; ?>
			<div class="custom-col-8">
				<div class="portfolio-item-wrapper">
						<?php $portfolio_args = array(
							'post_type'   => 'post',
							'posts_per_page' => absint( $portfolio_number ),
			                'post_status' => 'publish',
			                'paged' => 1,
						);
						if ( absint( $portfolio_category ) > 0 ) {
							$portfolio_args['cat'] = absint( $portfolio_category );
						}			

						// Fetch posts.
						$the_query = new WP_Query( $portfolio_args );						
						if ( $the_query->have_posts() ) : $count= 0; ?>
							<div class="owl-carousel owl-theme portfolio-slider">
								<?php while ( $the_query->have_posts() ) : $the_query->the_post(); $count++;?>
		                            <?php $image = '';
			                            if ( !has_post_thumbnail() ){
			                                $image = 'no-image';
			                            } 
		                            ?>
									<div class="portfolio-item <?php echo esc_attr( $image );?>">
										<a href="<?php the_permalink();?>" id="<?php the_ID(); ?>" class="view-btn portfolio-view"><?php echo esc_html__( 'View', 'rt-portfolio' );?></a>
										<a class="portfolio-image portfolio-view" href="<?php the_permalink();?>">
											<figure>
												<?php the_post_thumbnail( 'rt-portfolio-portfolio' );?>
											</figure>
										</a>
										<h3 class="entry-title">
											<a href="<?php the_permalink()?>" class="portfolio-view"><?php the_title();?></a>
										</h3>
									</div>
								<?php endwhile;
								wp_reset_postdata(); ?>
							</div>
						<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>