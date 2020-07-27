<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package RT_Portfolio
 */

get_header();
?>
<div class="section service-section">
	<div class="container">
		<div class="row">
			<div class="custom-col-4">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'rt-portfolio' ); ?></h1>
				</header><!-- .page-header -->
			</div>
			<div class="custom-col-8">
				<section class="error-404 not-found">
					<div class="page-content">
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'rt-portfolio' ); ?></p>

						<?php
						get_search_form();
						?>
					</div><!-- .page-content -->					
				</section><!-- .error-404 -->
			</div>

		</div>
	</div>
</div>
<?php
get_footer();
