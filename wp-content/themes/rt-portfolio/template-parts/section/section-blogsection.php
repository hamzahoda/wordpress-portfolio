<?php
/**
 * Template for Blog Section
 *
 * @package RT_Portfolio
 */
$enable_blog = rt_portfolio_get_option( 'enable_blog' );

if ( false == $enable_blog ){
    return;
}
$blog_section_title  = rt_portfolio_get_option( 'blog_section_title' );
$blog_category     = rt_portfolio_get_option( 'blog_category' );
$blog_number     = rt_portfolio_get_option( 'blog_number' );
?>

<div class="section blog-section" id="blogsection">
	<div class="container">
		<div class="row">
			<?php if ( ! empty( $blog_section_title ) ): ?>
				<div class="custom-col-4">
					<header class="entry-header heading">
						<h2 class="entry-title"><?php echo esc_html( $blog_section_title );?></h2>
					</header>
				</div>
			<?php endif; ?>
			<div class="custom-col-8">
                <?php $blog_args = array(
                    'post_type'   => 'post',
                    'posts_per_page' => absint( $blog_number ),
                    'post_status' => 'publish',
                    'paged' => 1,
                );
                if ( absint( $blog_category ) > 0 ) {
                    $blog_args['cat'] = absint( $blog_category );
                }           

                // Fetch posts.
                $the_query = new WP_Query( $blog_args );                     
                if ( $the_query->have_posts() ) : $count= 0; ?>				
					<div class="post-item-wrapper">
						<?php while ( $the_query->have_posts() ) : $the_query->the_post(); 
						$image = '';
						if ( !has_post_thumbnail() ){
							$image = 'no-image';
						}
						?>
							<div class="post <?php echo esc_attr( $image );?>">
								<figure class="featured-image">
									<?php the_post_thumbnail( 'rt-portfolio-blog' )?>
								</figure>
								<div class="post-content">
									<header class="entry-header">
										<div class="entry-meta">
											<?php rt_portfolio_posted_on();
												rt_portfolio_categories(); 
											?>
										</div>
										<h3 class="entry-title">
											<a href="<?php the_permalink()?>"><?php the_title();?></a>
										</h3>
									</header>
									<div class="entry-content">
										<?php
		                                    $excerpt = rt_portfolio_the_excerpt( 20 );
		                                    echo wp_kses_post( wpautop( $excerpt ) );
		                                ?>
									</div>
								</div>
								<hr>
							</div>	
						<?php endwhile;
						wp_reset_postdata();?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>