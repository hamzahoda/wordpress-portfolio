<?php
/**
 * The template for displaying the portfolio component
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}
//global
$section = get_query_var( 'section');
$title = $section['title'];
$subtitle = $section['subtitle'];
$menu_id = $section['menu_id'];
$enable_bottom_line = $section['enable_bottom_line'];

$categories = $section['categories'];
$disable_related_projects = $section['disable_related_projects'];
$title_for_related_projects = $section['title_for_related_projects'];

$tax_query = '';
if(!empty($categories)){
    $tax_query = array(
            array(
                'taxonomy' => 'certy_portfolio_category',
                'field' => 'term_id',
                'terms' => $categories
            )
        );
}

$args_posts = array(
    'posts_per_page'   => -1,
    'orderby'          => 'date',
    'order'            => 'DESC',
    'post_type'        => 'certy_portfolio',
    'tax_query'        => $tax_query,
    'post_status'      => 'publish',
    'suppress_filters' => true
);
$all_cat = true;
if(!empty($categories) && count($categories)==1):
    $all_cat = false;
endif;
$enable_bottom_line = $section['enable_bottom_line'];
$brd_class = '';
if(!empty($enable_bottom_line)){
    $brd_class=' brd-btm';
}
?>
<section<?php if(!empty($menu_id)):?> id="<?php echo esc_attr($menu_id);?>"<?php endif;?> class="section padd-box<?php echo esc_attr($brd_class);?>">
    <?php if(!empty($title)):?>
        <h2 class="title-lg text-upper"><?php echo esc_html($title);?></h2>
    <?php endif;?>
    <?php if(!empty($subtitle)):?>
        <h3 class="title-thin text-muted"><?php echo esc_html($subtitle);?></h3>
    <?php endif;?>
    <div class="pf-wrap">
        <?php if($all_cat):?>
            <div class="pf-filter padd-box">
                <button data-filter="*"><?php esc_html_e('All','certy');?></button>
                <?php
                $args = array(
                    'hide_empty'             => false,
                    'include'                => $categories,
                    'number'                 => '',
                );

                $terms = get_terms('certy_portfolio_category', $args);
                foreach($terms as $term):
                ?>
                    <button data-filter=".pf-<?php echo esc_attr($term->slug);?>"><?php echo esc_html($term->name);?></button>
                <?php endforeach;?>
            </div>
        <?php endif;?>

        <div class="pf-grid">
            <div class="pf-grid-sizer"></div>
            <?php
                $posts_array = get_posts( $args_posts );
                if($posts_array): $i=1;
                    foreach($posts_array as $post):setup_postdata($post);
                        $image_size_for_grid = get_field('image_size_for_grid');
                        $popup_slider = get_field('popup_slider');
                        $info_fields = get_field('info_fields');
                        $terms = get_the_terms( get_the_ID(), 'certy_portfolio_category' );
                        $term_slug = '';
                        $term_name = '';
                        if($terms):
                            foreach($terms as $term_item){
                                $term_slug .= ' pf-'.$term_item->slug;
                                $term_name .= $term_item->name.' / ';
                            }
                        endif;
            ?>
                        <article class="pf-grid-item<?php echo esc_attr($term_slug);?>">
                            <a class="pf-project" href="#pf-popup-<?php the_ID();?>">
                                <figure class="pf-figure">
                                    <?php
                                    if(has_post_thumbnail()):
                                        the_post_thumbnail( 'certy-portfolio');
                                    endif;
                                    ?>
                                </figure>

                                <div class="pf-caption text-center">
                                    <div class="valign-table">
                                        <div class="valign-cell">
                                            <h2 class="pf-title text-upper"><?php the_title();?></h2>
                                            <?php if(has_excerpt()):?>
                                                <div class="pf-text clear-mrg">
                                                    <?php the_excerpt();?>
                                                </div>
                                            <?php endif;?>

                                            <span class="pf-btn btn btn-primary"><?php esc_html_e('View More','certy');?></span>
                                        </div>
                                    </div>
                                </div>
                            </a><!-- .pf-project -->

                            <div id="pf-popup-<?php the_ID();?>" class="pf-popup clearfix">
                                <?php if(!empty($popup_slider)):?>
                                    <div class="pf-popup-col1">
                                        <div class="pf-popup-media cr-slider" data-init="none">
                                            <?php foreach($popup_slider as $slide):
                                                    if($slide['media_type']=='image' && !empty($slide['image'])){
                                                        $image = wp_get_attachment_image_src( $slide['image'], 'certy-portfolio-popup');
                                                        $data_url = $image[0];
                                                    }elseif($slide['media_type']=='iframe' && !empty($slide['iframe_url'])){
                                                        $data_url = $slide['iframe_url'];
                                                    }elseif($slide['media_type']=='video' && (!empty($slide['mp4_file']) || !empty($slide['webm_file']) || !empty($slide['ogv_file']))){
                                                        $data_url = '';
                                                        if(!empty($slide['poster_image'])){
                                                            $poster = wp_get_attachment_image_src( $slide['poster_image'], 'certy-portfolio-popup');
                                                            $data_url .='poster: '.$poster[0].', ';
                                                        }
                                                        if(!empty($slide['mp4_file'])){
                                                            $data_url .='mp4: '.$slide['mp4_file'].', ';
                                                        }
                                                        if(!empty($slide['webm_file'])){
                                                            $data_url .='webm: '.$slide['webm_file'].', ';
                                                        }
                                                        if(!empty($slide['ogv_file'])){
                                                            $data_url .='ogv: '.$slide['ogv_file'];
                                                        }
                                                    }
                                                ?>
                                                <div class="pf-popup-slide">
                                                    <div class="pf-popup-embed" data-type="<?php echo esc_attr($slide['media_type'] );?>" data-width="419" data-height="293" data-url="<?php echo esc_attr($data_url);?>"></div>
                                                </div>
                                            <?php endforeach;?>
                                        </div>
                                    </div>
                                <?php endif;?>

                                <div class="pf-popup-col2">
                                    <div class="pf-popup-info">
                                        <h2 class="pf-popup-title text-upper"><?php the_title();?></h2>
                                        <?php if(!empty($terms)):?>
                                            <p class="text-muted">
                                                <strong><?php echo esc_html($term_name);?></strong>
                                            </p>
                                        <?php endif;?>
                                        <?php if(!empty($info_fields)):?>
                                            <dl class="dl-horizontal">
                                                <?php foreach($info_fields as $field):
                                                    if(!empty($field['name'])):
                                                    ?>
                                                        <dt><?php echo esc_html($field['name']);?></dt>
                                                    <?php endif;?>
                                                    <?php if(!empty($field['value'])):?>
                                                        <dd><?php echo wp_kses_post($field['value']);?></dd>
                                                    <?php endif;?>
                                                <?php endforeach;?>
                                            </dl>
                                        <?php endif;?>

                                        <?php the_content();?>
                                    </div>
                                    <?php if(empty($disable_related_projects)):?>
                                        <div class="pf-popup-rel">
                                            <?php if(!empty($title_for_related_projects)):?>
                                                <h2 class="pf-rel-title text-upper"><?php echo esc_html($title_for_related_projects);?></h2>
                                            <?php endif;?>
                                            <?php
                                            $related_term = get_the_terms( get_the_ID(), 'certy_portfolio_category' );
                                            $related_term_id = array();
                                            if(!empty($related_term)):
                                                foreach($related_term as $term):
                                                    $related_term_id[] = $term->term_id;
                                                endforeach;
                                                $args_posts = array(
                                                    'posts_per_page'   => -1,
                                                    'orderby'          => 'date',
                                                    'order'            => 'DESC',
                                                    'post_type'        => 'certy_portfolio',
                                                    'tax_query'        => array(
                                                                            array(
                                                                                'taxonomy' => 'certy_portfolio_category',
                                                                                'field' => 'term_id',
                                                                                'terms' => $related_term_id
                                                                            )
                                                                        ),
                                                    'post_status'      => 'publish',
                                                    'suppress_filters' => true
                                                    );
                                                $posts_array = get_posts( $args_posts );
                                                if($posts_array):
                                                ?>
                                                    <div class="pf-rel-carousel cr-carousel" data-init="none">
                                                        <?php foreach($posts_array as $post):setup_postdata($post);?>
                                                            <div class="pf-rel-project">
                                                                <a class="pf-rel-href" href="#pf-popup-<?php the_ID();?>">
                                                                    <?php
                                                                    if(has_post_thumbnail()):
                                                                        the_post_thumbnail( 'certy-portfolio-popup-related');
                                                                    endif;
                                                                    ?>
                                                                    <span class="pf-rel-cover">
                                                                        <span class="btn btn-primary btn-sm"><?php esc_html_e('View','certy');?></span>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        <?php $i++; endforeach; wp_reset_postdata();?>
                                                    </div>
                                                <?php endif;?>
                                            <?php endif;?>
                                        </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </article>
                    <?php $i++; endforeach; wp_reset_postdata();?>
                <?php endif;?>
        </div>
    </div>
</section>