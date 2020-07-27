<?php
/**
 * The template for displaying search results pages
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

get_header(); ?>
	<div class="crt-paper-layers">
		<div class="crt-paper clearfix">
			<div class="crt-paper-cont paper-padd clear-mrg">
				<div class="padd-box-sm clear-mrg">
					<header class="search-for">
						<h1 class="search-title text-muted"><?php _e('search results for:','certy');?>
							<span><?php echo get_search_query();?></span></h1>
					</header>
					<div class="search-result">
						<?php
						if ( have_posts() ) :
							while ( have_posts() ) : the_post();
								?>
								<article class="post hentry">
									<?php if(has_post_thumbnail()):?>
										<div class="post-media">
											<a href="<?php the_permalink();?>" rel="bookmark">
												<figure class="post-figure">
													<?php the_post_thumbnail( 'certy-blog');?>
												</figure>
											</a>
										</div>
									<?php endif;?>
									<header class="post-header text-center">
										<h2 class="post-title entry-title text-upper"><a rel="bookmark" href="<?php the_permalink();?>"><?php the_title();?></a></h2>
									</header>
									<div class="post-content entry-content editor clearfix clear-mrg">
										<?php the_excerpt();?>
									</div>
									<footer class="post-footer">
										<div class="post-footer-top brd-btm clearfix">
											<div class="post-more">
												<a class="btn btn-sm btn-primary" href="<?php the_permalink();?>" rel="bookmark"><?php _e( 'Read More', 'certy' )?></a>
											</div>
										</div>
									</footer>
								</article>
							<?php endwhile;
						else:
							?>
							<strong class="title-lg text-upper"><?php _e('nothing found','certy');?></strong>
							<?php get_search_form();?>
						<?php endif;?>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php get_footer();
