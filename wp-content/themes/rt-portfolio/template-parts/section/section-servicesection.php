<?php
/**
 * Template for Home Section
 *
 * @package RT_Portfolio
 */

$enable_service = rt_portfolio_get_option( 'enable_service' );

if ( false == $enable_service ){
    return;
}
$service_section_title 	= rt_portfolio_get_option( 'service_section_title' );
$service_category 		= rt_portfolio_get_option( 'service_category' );
$service_number 		= rt_portfolio_get_option( 'service_number' );
?>


	<div class="home-section section service-section" id="servicesection">
		<div class="container">
			<div class="row">
				<?php if( $service_section_title ): ?>
					<div class="custom-col-4">
						<header class="entry-header heading">
							<h2 class="entry-title"><?php echo esc_html( $service_section_title);?></h2>
						</header>
					</div>
				<?php endif; ?>

				<div class="custom-col-8">
					<div class="service-item-wrapper">
						<?php $service_args = array(
							'post_type'   => 'post',
							'posts_per_page' => absint( $service_number ),
			                'post_status' => 'publish',
			                'paged' => 1,
						);
						if ( absint( $service_category ) > 0 ) {
							$service_args['cat'] = absint( $service_category );
						}			

						// Fetch posts.
						$the_query = new WP_Query( $service_args );						
						if ( $the_query->have_posts() ) : $count= 0;
							while ( $the_query->have_posts() ) : $the_query->the_post(); $count++;?>
								<div class="service-item">
									<?php if ( has_post_thumbnail() ): ?>
										<figure class="service-icon">
											<?php the_post_thumbnail();?>
										</figure>
									<?php endif; ?>
									<h3 class="entry-title">
										<a href="<?php the_permalink()?>"><?php the_title()?></a>
									</h3>
	                                <?php
	                                    $excerpt = rt_portfolio_the_excerpt( 12);
	                                    echo wp_kses_post( wpautop( $excerpt ) );
	                                ?>
								</div>							
							<?php endwhile;
							wp_reset_postdata();
						endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>