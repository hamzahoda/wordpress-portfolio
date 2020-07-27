<?php
/**
 * The template for displaying the clients component
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
$clients_posts = $section['select_clients_posts'];
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
<section<?php if(!empty($menu_id)):?> id="<?php echo esc_attr($menu_id);?>"<?php endif;?> class="section clear-mrg padd-box<?php echo esc_attr($brd_class);?>">
    <?php if(!empty($title)):?>
        <h2 class="title-lg text-upper"><?php echo esc_html($title);?></h2>
    <?php endif;?>
    <?php if(!empty($subtitle)):?>
        <h3 class="title-thin text-muted"><?php echo esc_html($subtitle);?></h3>
    <?php endif;?>
    <?php if(!empty($clients_posts)):?>
        <div class="padd-box-sm">
            <ul class="clients clear-list">
                <?php
                foreach($clients_posts as $post):setup_postdata($post);
                    $link = get_field('link');
                    if(has_post_thumbnail()):
                    ?><li>
                            <?php if(!empty($link)):?>
                            <a target="_blank" href="<?php echo esc_url($link);?>">
                            <?php endif;?>
                                <?php the_post_thumbnail( 'certy-thumbnail', ['class' => $image_class]);?>
                            <?php if(!empty($link)):?>
                            </a>
                            <?php endif;?></li><?php endif; endforeach; wp_reset_postdata();?>
            </ul>
        </div>
    <?php endif;?>
</section>