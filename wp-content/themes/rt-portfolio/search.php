<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
					<header class="page-header">
						<h1 class="page-title">
							<?php
							/* translators: %s: search query. */
							printf( esc_html__( 'Search Results for: %s', 'rt-portfolio' ), '<span>' . get_search_query() . '</span>' );
							?>
						</h1>
					</header><!-- .page-header -->
				</div>
				<div class="custom-col-8">
					<div class="service-detail-wrapper">

						<?php
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'search' );

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
