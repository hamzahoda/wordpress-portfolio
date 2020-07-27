<?php
/**
 * The template for displaying the Timeline component
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}
$section = get_query_var( 'section');
$title = $section['title'];
$subtitle = $section['subtitle'];
$menu_id = $section['menu_id'];
$timeline_posts = $section['select_timeline_posts'];
$enable_bottom_line = $section['enable_bottom_line'];
$grayscale_and_color_on_hover = $section['grayscale_and_color_on_hover'];

$brd_class = '';
if(!empty($enable_bottom_line)){
    $brd_class=' brd-btm';
}

$image_class = '';
if(!empty($grayscale_and_color_on_hover)){
    $image_class='crt-bw';
}
?>
<section<?php if(!empty($menu_id)):?> id="<?php echo esc_attr($menu_id);?>"<?php endif;?> class="section padd-box<?php echo esc_attr($brd_class);?>">
    <?php if(!empty($title)):?>
        <h2 class="title-lg text-upper"><?php echo esc_html($title);?></h2>
    <?php endif;?>
    <?php if(!empty($subtitle)):?>
        <h3 class="title-thin text-muted"><?php echo esc_html($subtitle);?></h3>
    <?php endif;?>
    <?php if(!empty($timeline_posts)):?>
        <div class="education">
            <?php
            foreach($timeline_posts as $post):setup_postdata($post);
                $secondary_title = get_field('secondary_title');
                $secondary_title_link = get_field('secondary_title_link');
                $title_link = get_field('title_link');
                $featured_image_link = get_field('featured_image_link');
                $period = get_field('period');
	            $open_in_new_tab = get_field('open_in_new_tab');
	            $target= '';
	            if( !empty( $open_in_new_tab ) ){
		            $target = ' target="_blank"';
	            }
                ?>
                <div class="education-box">
                    <?php if(!empty($period)):?>
                        <span class="education-date">
                            <span><?php echo wp_kses_post($period);?></span>
                        </span>
                    <?php endif;?>
                    <h3>
                        <?php if(!empty($title_link)):?>
                            <a<?php echo esc_attr($target);?> href="<?php echo esc_url($title_link);?>">
                        <?php endif;?>
                        <?php the_title();?>
                        <?php if(!empty($title_link)):?>
                            </a>
                        <?php endif;?>
                    </h3>
                    <?php if(has_post_thumbnail()):?>
                        <div class="education-logo">
                            <?php if(!empty($featured_image_link)):?>
                            <a<?php echo esc_attr($target);?> href="<?php echo esc_url($featured_image_link);?>">
                            <?php endif;?>
                                <?php the_post_thumbnail('certy-thumbnail', ['class' => $image_class])?>
                            <?php if(!empty($featured_image_link)):?>
                            </a>
                            <?php endif;?>
                        </div>
                    <?php endif;?>
                    <?php if($secondary_title):?>
                        <?php if(!empty($secondary_title_link)):?>
                            <a<?php echo esc_attr($target);?> href="<?php echo esc_url($secondary_title_link);?>">
                        <?php endif;?>
                            <span class="education-company"><?php echo esc_html($secondary_title);?></span>
                        <?php if(!empty($secondary_title_link)):?>
                            </a>
                        <?php endif;?>
                    <?php endif;?>
                    <?php the_content();?>
                </div>
            <?php endforeach; wp_reset_postdata();?>
        </div>
    <?php endif;?>
</section>