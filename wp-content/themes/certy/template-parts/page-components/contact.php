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
$subtitle = $section['subtitle'];
$menu_id = $section['menu_id'];
$enable_bottom_line = $section['enable_bottom_line'];
$enable_social_icons = $section['enable_social_icons'];
$contact_title = $section['contact_title'];
$editor = $section['editor'];
$google_map_latitude = $section['google_map_latitude'];
$google_map_longitude = $section['google_map_longitude'];
$brd_class = '';
if(!empty($enable_bottom_line)){
$brd_class=' brd-btm';
}
?>
<section<?php if(!empty($menu_id)):?> id="<?php echo esc_attr($menu_id);?>"<?php endif;?> class="section<?php echo esc_attr($brd_class);?> padd-box">
    <?php if(!empty($title)):?>
        <h2 class="title-lg text-upper"><?php echo esc_html($title);?></h2>
    <?php endif;?>

    <div class="padd-box-sm">
        <?php if(!empty($subtitle)):?>
            <h3 class="title-thin text-muted"><?php echo esc_html($subtitle);?></h3>
        <?php endif;?>

        <?php if(!empty($enable_social_icons) || !empty($contact_title)):?>
            <header class="contact-head">
                <?php
                if(!empty($enable_social_icons)):
                    get_template_part('template-parts/social');
                endif;
                ?>
                <?php if(!empty($contact_title)):?>
                    <h3 class="title text-upper"><?php echo esc_html($contact_title);?></h3>
                <?php endif;?>
            </header>
        <?php endif;?>

        <?php if(!empty($editor)):?>
            <?php echo do_shortcode($editor);?>
        <?php endif;?>
    </div>

    <?php if(!empty($google_map_latitude) && !empty($google_map_longitude)):?>
        <div id="map" data-latitude="<?php echo esc_attr($google_map_latitude);?>" data-longitude="<?php echo esc_attr($google_map_longitude);?>"></div>
    <?php endif;?>
</section>