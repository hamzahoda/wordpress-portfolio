<?php
/**
 * Template for Testimonial Section
 *
 * @package RT_Portfolio
 */
$enable_testimonial = rt_portfolio_get_option( 'enable_testimonial' );

if ( false == $enable_testimonial ){
    return;
}
$testimonial_section_title 	= rt_portfolio_get_option( 'testimonial_section_title' );
$testimonial_category 		= rt_portfolio_get_option( 'testimonial_category' );
$testimonial_number 		= rt_portfolio_get_option( 'testimonial_number' );
?>

<div class="section testimonial-section" id="testimonialsection">
	<div class="container">
		<div class="row">
			<?php if ( $testimonial_section_title ): ?>
				<div class="custom-col-4">
					<header class="entry-header heading">
						<h2 class="entry-title"><?php echo esc_html( $testimonial_section_title );?></h2>
					</header>
				</div>
			<?php endif;?>

			<div class="custom-col-8">
				<div class="testimonial-wrapper">
					<div class="testimonial-item-wrapper">						
						<?php $service_args = array(
							'post_type'   => 'post',
							'posts_per_page' => absint( $testimonial_number ),
			                'post_status' => 'publish',
			                'paged' => 1,
						);
						if ( absint( $testimonial_category ) > 0 ) {
							$service_args['cat'] = absint( $testimonial_category );
						}			

						// Fetch posts.
						$the_query = new WP_Query( $service_args );						
						if ( $the_query->have_posts() ) : $count= 0; ?>
							<div class="owl-carousel owl-theme testimonial-slider">
								<?php while ( $the_query->have_posts() ) : $the_query->the_post(); $count++;?>
	                            <?php $image = '';
	                            if ( !has_post_thumbnail() ){
	                                $image = 'no-image';
	                            } 
	                            ?>	
									<div class="single-testimonial <?php echo esc_attr( $image);?>">
										<figure class="author-img">
											<?php the_post_thumbnail( 'rt-portfolio-testimonial' );?>
										</figure>										
										<div class="testimonial-content">
											<h4 class="author-name">
												<a href="<?php the_permalink();?>"><?php the_title();?></a>
											</h4>
											<?php
			                                    $excerpt = rt_portfolio_the_excerpt(15);
			                                    echo wp_kses_post( wpautop( $excerpt ) );
			                                ?>
										</div>
									</div>
								<?php endwhile;
								wp_reset_postdata();?>
							</div>
						<?php endif; ?>
					</div>
					<?php $partner_title 	= rt_portfolio_get_option( 'partner_title' ); 
					$partner_logo = rt_portfolio_get_option( 'partner_logo' );
					$enable_partner 		= rt_portfolio_get_option( 'enable_partner' );
                    $partner_logo = json_decode( $partner_logo );
                    if ( true == $enable_partner ):
	                    if ( $partner_logo ):
	                    ?>                        
							<div class="partner-section">
								<h3><?php echo esc_html( $partner_title );?></h3>
								<div class="partner-item-wrapper">
									<div class="owl-carousel owl-theme partner-slider">
										<?php foreach ( $partner_logo as  $partner) {
				                            $client_logo = $partner->client_logo;
				                            if( !empty( $client_logo ) ) {
				                        	?>
												<figure class="partner-item">
													<a href="#">
														<img src="<?php echo esc_url( $client_logo);?>" alt="<?php the_title_attribute()?>">
													</a>
												</figure>
											<?php } 
										} ?>
									</div>
								</div>
							</div>	
						<?php endif; 
					endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>