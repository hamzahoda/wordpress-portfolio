<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package RT_Portfolio
 */

?>


		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<figure class="featured-image">
				<?php the_post_thumbnail();?>
			</figure>
			<h3 class="entry-title">
				<a href="#"><?php the_title();?></a>
			</h3>
			<div class="entery-content">
				<?php the_content();?>
			</div>
		</article>
