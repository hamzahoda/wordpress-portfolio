<?php
/**
 * The main template file
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if (!defined('ABSPATH')) {
    die('No direct script access allowed');
}

get_header();
$blog_separate_paper = kirki::get_option('certy_kirki_config', 'blog_separate_paper');
$disable_paper_animation = kirki::get_option('certy_kirki_config', 'disable_paper_animation');
if (empty($blog_separate_paper)):
    ?>
    <div class="crt-paper-layers<?php if (empty($disable_paper_animation)): ?> crt-animate<?php endif; ?>">
    <div class="crt-paper clearfix">
    <div class="crt-paper-cont paper-padd clear-mrg">
<?php endif; ?>
<?php
if (have_posts()):
    while (have_posts()):the_post();
        get_template_part('template-parts/post-components/post-single');
    endwhile;
    wp_reset_postdata();
    get_template_part('template-parts/post-components/pagination');
endif;
if (empty($blog_separate_paper)):
    ?>

    </div>
    </div>
    </div>
<?php endif; ?>
<?php get_footer(); ?>