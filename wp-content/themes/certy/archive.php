<?php
/**
 * The template for displaying archives
 *
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

get_header();
$blog_separate_paper = kirki::get_option('certy_kirki_config','blog_separate_paper');
$disable_paper_animation = kirki::get_option('certy_kirki_config','disable_paper_animation');
if(empty($blog_separate_paper)):
?>
<div class="crt-paper-layers<?php if(empty($disable_paper_animation)):?> crt-animate<?php endif;?>">
    <div class="crt-paper clearfix">
        <div class="crt-paper-cont paper-padd clear-mrg">
            <?php endif;?>
            <header class="page-header padd-box">
                <h1 class="title-lg text-upper"><?php echo get_the_archive_title();?></h1>
            </header>
            <?php
            if( get_query_var( 'paged' ) ):
                $my_page = get_query_var( 'paged' );
            else:
                if( get_query_var( 'page' ) ):
                    $my_page = get_query_var( 'page' );
                else:
                    $my_page = 1;
                endif;
                set_query_var( 'paged', $my_page );
                $paged = $my_page;
            endif;
            $posts_per_page = get_option('posts_per_page');
            $year = ( get_query_var( 'year' ) ) ? get_query_var( 'year' ) : false;
            $month = ( get_query_var( 'monthnum' ) ) ? zeroise( get_query_var( 'monthnum' ), 2 ) : false;
            $day = ( get_query_var( 'day' ) ) ? get_query_var( 'day' ) : false;
            query_posts(array(
                'posts_per_page' => intval($posts_per_page),
                'paged' => $paged,
                'post_type' => 'post',
                'year'     => $year,
                'monthnum' => $month,
                'day' => $day,
            ));
            if(have_posts()):
                while(have_posts()):the_post();
                    get_template_part('template-parts/post-components/post-single');
                endwhile;
                wp_reset_postdata();
                get_template_part('template-parts/post-components/pagination');
            endif;
            if(empty($blog_separate_paper)):
            ?>
        </div>
    </div>
</div>
<?php endif;?>
<?php get_footer();?>

