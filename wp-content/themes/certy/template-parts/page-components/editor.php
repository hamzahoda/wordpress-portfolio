<?php
/**
 * The template for displaying the editor component
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
$editor = $section['editor'];
$enable_bottom_line = $section['enable_bottom_line'];
$brd_class = '';
if(!empty($enable_bottom_line)){
    $brd_class=' brd-btm';
}
?>
<section<?php if(!empty($menu_id)):?> id="<?php echo esc_attr($menu_id);?>"<?php endif;?> class="section padd-box<?php echo esc_attr($brd_class);?>">
    <div class="row">
        <div class="col-sm-12 clear-mrg text-box">
            <?php if(!empty($title)):?>
                <h2 class="title-lg text-upper"><?php echo esc_html($title);?></h2>
            <?php endif;?>
            <?php if(!empty($subtitle)):?>
                <h3 class="title-thin text-muted"><?php echo esc_html($subtitle);?></h3>
            <?php endif;?>
            <?php
            if(!empty($editor)):
                echo $editor;
            endif;
            ?>
        </div>
    </div>
</section>