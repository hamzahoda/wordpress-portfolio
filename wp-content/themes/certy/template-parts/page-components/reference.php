<?php
/**
 * The template for displaying the reference component
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
$reference_posts = $section['select_reference_posts'];
$enable_bottom_line = $section['enable_bottom_line'];
$grayscale_and_color_on_hover = $section['grayscale_and_color_on_hover'];

$brd_class = '';
if(!empty($enable_bottom_line)){
    $brd_class=' brd-btm';
}

$image_class = 'avatar avatar-54 photo';
if(!empty($grayscale_and_color_on_hover)){
    $image_class='avatar avatar-54 photo crt-bw';
}
?>
<section<?php if(!empty($menu_id)):?> id="<?php echo esc_attr($menu_id);?>"<?php endif;?> class="section padd-box<?php echo esc_attr($brd_class);?>">
    <?php if(!empty($title)):?>
        <h2 class="title-lg text-upper"><?php echo esc_html($title);?></h2>
    <?php endif;?>
    <?php if(!empty($subtitle)):?>
        <h3 class="title-thin text-muted"><?php echo esc_html($subtitle);?></h3>
    <?php endif;?>
    <?php
        if(!empty($reference_posts)):?>
            <div class="ref-box-list padd-box-sm clear-mrg">
                <?php
                foreach($reference_posts as $post):setup_postdata($post);
                    $secondary_title = get_field('secondary_title');
                    $secondary_title_link = get_field('secondary_title_link');
                    $featured_image_link = get_field('featured_image_link');
                    $open_in_new_tab = get_field('open_in_new_tab');
	                $target= '';
                    if( !empty( $open_in_new_tab ) ){
                        $target = ' target="_blank"';
                    }
                ?>
                    <div class="ref-box brd-btm hreview">
                        <?php if(has_post_thumbnail()):?>
                            <div class="ref-avatar">
                                <?php if(!empty($featured_image_link)):?>
                                <a<?php echo esc_attr($target);?> href="<?php echo esc_url($featured_image_link);?>">
                                <?php endif;?>
                                    <?php echo certy_post_thumbnail(get_the_ID(),'', 'certy-thumbnail-references',$image_class );?>
                                <?php if(!empty($featured_image_link)):?>
                                </a>
                                <?php endif;?>
                            </div>
                        <?php endif;?>
                        <div class="ref-info">
                            <div class="ref-author">
                                <strong><?php the_title();?></strong>
                                <?php if($secondary_title):?>
                                    <?php if(!empty($secondary_title_link)):?>
                                    <a<?php echo esc_attr($target);?> href="<?php echo esc_url($secondary_title_link);?>">
                                    <?php endif;?>
                                        <span><?php echo esc_html($secondary_title);?></span>
                                    <?php if(!empty($secondary_title_link)):?>
                                    </a>
                                    <?php endif;?>
                                <?php endif;?>
                            </div>

                            <blockquote class="ref-cont clear-mrg">
                                <?php the_content();?>
                            </blockquote>
                        </div>
                    </div>
            <?php endforeach; wp_reset_postdata();?>
        </div>
    <?php endif;?>
</section>