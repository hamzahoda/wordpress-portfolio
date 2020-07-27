<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
            <?php
            if(have_posts()):the_post();
                get_template_part('template-parts/post-components/post-single');
                get_template_part('template-parts/post-components/navigation');
                if (comments_open()) {
                    comments_template('', true);
                }
            endif;
            ?>
        </div>
    </div>
</div>
<?php get_footer();?>
