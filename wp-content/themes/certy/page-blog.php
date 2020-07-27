<?php
/**
 * The template for displaying the page
 *
 * template name: Blog
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
            <?php if(have_posts()):the_post();?>
                <header class="page-header padd-box">
                    <h1 class="title-lg text-upper"><?php the_title();?></h1>
                </header>
            <?php endif;?>
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
            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => $posts_per_page,
                'orderby' => 'date',
                'order' => 'DESC',
                'paged' => $paged
            );

            $blog_posts = new WP_Query($args);
            if($blog_posts->have_posts()):
                while($blog_posts->have_posts()):$blog_posts->the_post();
                    get_template_part('template-parts/post-components/post-single');
                endwhile;
                wp_reset_postdata();
            if ( $blog_posts->max_num_pages > 1 ) :
            ?>
                <div class="pagination">
                    <?php
                    $total = $blog_posts->found_posts;
                    $page = isset( $_GET['page'] ) ? abs( (int) $_GET['page'] ) : 1;
                    $format = 'page/%#%/';
                    $current_page = max(1, $paged);
                    $big = 999999999;
                    echo paginate_links( array(
                        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format' => '?page=%#%',
                        'end_size'           => 1,
                        'mid_size'           => 2,
                        'prev_next'          => True,
                        'prev_text'          => '<i class="crt-icon crt-icon-chevron-left"></i>',
                        'next_text'          => '<i class="crt-icon crt-icon-chevron-right"></i>',
                        'type'               => 'plain',
                        'add_args'           => False,
                        'add_fragment'       => '',
                        'before_page_number' => '',
                        'after_page_number'  => '',
                        'total' => ceil($total / $posts_per_page),
                        'current' => $current_page,
                    ));
                    ?>
                </div>
            <?php
            endif;
            endif;
            if(empty($blog_separate_paper)):
            ?>

        </div>
    </div>
</div>
<?php endif;?>

<?php get_footer();?>
