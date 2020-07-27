<?php
/**
 * The template for post single
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}
$comment_link = get_comments_link();
$comment_number = get_comments_number();
$post_format = get_post_format();
$slider_images = get_field('slider_images');
$disable_paper_animation = kirki::get_option('certy_kirki_config','disable_paper_animation');
$blog_separate_paper = kirki::get_option('certy_kirki_config','blog_separate_paper');
$hide_excerpts = kirki::get_option('certy_kirki_config','hide_excerpts');
$show_featured = kirki::get_option('certy_kirki_config','show_featured');
if(!empty($blog_separate_paper) && $blog_separate_paper == '1' && !is_single()):
?>
<div class="crt-paper-layers<?php if(empty($disable_paper_animation)):?> crt-animate<?php endif;?>">
    <div class="crt-paper clearfix">
        <div class="crt-paper-cont paper-padd clear-mrg">
<?php endif;?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if(!empty($slider_images) || has_post_thumbnail()):?>
                    <div class="post-media">
                        <?php if($post_format == 'gallery' && !empty($slider_images)):?>
                            <div class="post-slider cr-slider" data-slick='{"adaptiveHeight": true}'>
                                <?php foreach($slider_images as $image): ?>
                                    <div>
                                        <a href="<?php the_permalink();?>" rel="bookmark">
                                            <?php echo wp_get_attachment_image( $image['ID'], 'certy-blog' ); ?>
                                        </a>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        <?php elseif(is_single()):
                                $put_audio = get_field('put_audio');
                                $put_video = get_field('put_video');
                                if($post_format == 'audio' && !empty($put_audio)):
                            ?>
                                    <div class="post-audio">
                                        <?php echo do_shortcode($put_audio);?>
                                    </div>
                                <?php elseif($post_format == 'video'):?>
                                    <div class="post-video">
                                        <?php echo do_shortcode($put_video);?>
                                    </div>
                                <?php elseif(has_post_thumbnail() && !empty($show_featured)):?>
                                    <figure class="post-figure">
                                        <?php the_post_thumbnail( 'certy-blog');?>
                                    </figure>
                                <?php endif;?>
                        <?php else:?>
                            <a href="<?php the_permalink();?>" rel="bookmark">
                                <?php if(has_post_thumbnail()):?>
                                    <figure class="post-figure">
                                        <?php the_post_thumbnail( 'certy-blog');?>
                                    </figure>
                                <?php endif;?>
                                <?php if($post_format == 'video'):?>
                                    <span class="post-play"><i class="crt-icon crt-icon-play"></i></span>
                                <?php endif;?>
                                <?php if($post_format == 'audio'):?>
                                    <span class="post-voice"><i class="crt-icon crt-icon-volume-up"></i></span>
                                <?php endif;?>
                            </a>
                        <?php endif;?>
                    </div>
                <?php endif;?>
                <div class="padd-box-sm">
                    <header class="post-header text-center">
                        <h2 class="post-title entry-title text-upper"><a rel="bookmark" href="<?php the_permalink();?>"><?php the_title();?></a></h2>

                        <div class="post-header-info">
                            <?php certy_posted_on();?>
                        </div>
                    </header>
                    <?php if(empty($hide_excerpts)):?>
                        <div class="post-content entry-content editor clearfix clear-mrg">
                            <?php
                            if(is_single()){
                                the_content();
                            }elseif(strstr($post->post_content,'<!--more-->')) {
                                the_content();
                            }else{
                                the_excerpt();
                            }
                                $defaults = array(
                                    'before'           => '<p>' . esc_html__( 'Pages:','certy' ),
                                    'after'            => '</p>',
                                    'link_before'      => '',
                                    'link_after'       => '',
                                    'next_or_number'   => 'number',
                                    'separator'        => ' ',
                                    'nextpagelink'     => esc_html__( 'Next page','certy' ),
                                    'previouspagelink' => esc_html__( 'Previous page','certy' ),
                                    'pagelink'         => '%',
                                    'echo'             => 1
                                );

                                wp_link_pages( $defaults );
                            ?>
                        </div>
                    <?php endif;?>

                    <footer class="post-footer">
                        <div class="post-footer-top brd-btm clearfix">
                            <div class="post-footer-info">
                                <span class="post-cat-links"><span class="screen-reader-text"><?php _e( 'Categories', 'certy' )?></span>
                                    <?php
                                    $category = get_the_category();
                                    foreach($category as $cat):
                                        ?>
                                        <a href="<?php echo esc_url(get_category_link($cat->term_id));?>"><?php echo esc_html($cat->name);?></a>
                                    <?php endforeach;?>
                                </span>
                                <span class="post-line">|</span>
                                <a href="<?php echo esc_url($comment_link);?>" class="post-comments-count"><?php echo intval($comment_number);?> <?php _e( 'comments', 'certy' )?></a>
                            </div>
                            <?php if(!is_single() && !strstr($post->post_content,'<!--more-->')):?>
                                <div class="post-more">
                                    <a class="btn btn-sm btn-primary" href="<?php the_permalink();?>" rel="bookmark"><?php _e( 'Read More', 'certy' )?></a>
                                </div>
                            <?php endif;?>
                        </div>
                        <?php if(is_single() && has_tag()):?>
                            <div class="post-footer-btm">
                                <div class="post-tags">
                                    <span class="screen-reader-text"><?php _e( 'Tags', 'certy' )?> </span>
                                    <?php the_tags('', '', '' );?>
                                </div>
                            </div>
                        <?php endif;?>
                    </footer>
                </div>
            </article>
<?php if(!empty($blog_separate_paper) && $blog_separate_paper == '1' && !is_single()):?>
        </div>
    </div>
</div>
<?php endif;?>