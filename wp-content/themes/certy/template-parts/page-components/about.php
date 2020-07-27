<?php
/**
 * The template for displaying the about component
 *
 * @package Certy_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}
$section = get_query_var( 'section');
$title = $section['title'];
$menu_id = $section['menu_id'];
$image_id = $section['image'];
$hover_image_id = $section['hover_image'];
$subtitle = $section['subtitle'];
$enable_bottom_line = $section['enable_bottom_line'];
$enable_social_icons = $section['enable_social_icons'];
$editor = $section['editor'];
$center_hover_image = $section['center_hover_image'];
$brd_class = '';
if(!empty($enable_bottom_line)){
$brd_class=' brd-btm';
}
$center_class = 'crt-card-wide';
if(!empty($center_hover_image)){
    $center_class = 'crt-card-wide-center';
}
?>
<section<?php if(!empty($menu_id)):?> id="<?php echo esc_attr($menu_id);?>"<?php endif;?> class="section<?php echo esc_attr($brd_class);?> section-card">
    <div class="crt-card <?php echo esc_attr($center_class);?> bg-primary text-center">
        <?php if(!empty($image_id)):?>
            <div class="crt-card-avatar">
                <span class="crt-avatar-state">
                    <span class="crt-avatar-state1"><?php echo certy_post_thumbnail('', $image_id, 'certy-thumbnail-avatar', "avatar avatar-195" )?></span>
                    <?php if(!empty($hover_image_id)):?>
                        <span class="crt-avatar-state2"><?php echo certy_post_thumbnail('', $hover_image_id, 'certy-thumbnail-avatar', "avatar avatar-195" )?></span>
                    <?php endif;?>
                </span>
            </div>
        <?php endif;?>
        <div class="crt-card-info clear-mrg">
            <?php if(!empty($title)):?>
                <h2 class="text-upper"><?php echo esc_html($title);?></h2>
            <?php endif;?>
            <?php if(!empty($subtitle)):?>
                <p class="text-muted"><?php echo esc_html($subtitle);?></p>
            <?php endif;?>
            <?php
            if(!empty($enable_social_icons)):
                get_template_part('template-parts/social');
            endif;
            ?>
            <?php if(!empty($editor)):?>
                <div class="text-box clear-mrg">
                    <?php echo wp_kses_post($editor);?>
                </div>
            <?php endif;?>
        </div>
    </div>
</section>